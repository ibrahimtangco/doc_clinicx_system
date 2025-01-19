<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Patient;
use App\Models\Service;
use App\Models\Appointment;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\DailyPatientCapacity;
use Illuminate\Support\Facades\Auth;
use App\Notifications\NewReservation;
use App\Notifications\ApprovedReservation;
use App\Notifications\DeclinedReservation;
use App\Notifications\ReservationSubmitted;
use Illuminate\Support\Facades\Notification;

class ReservationController extends Controller
{
    public function generateQueueNumber($date, $schedule)
    {
        // Format the date to Ymd
        $formattedDate = Carbon::parse($date)->format('Ymd');

        // Retrieve the DailyPatientCapacity entry for the given date
        $dailyCapacity = DailyPatientCapacity::where('date', $formattedDate)->first();

        if (!$dailyCapacity) {
            return ['error' => "No capacity settings found for the selected date."];
        }

        // Check capacity based on the selected schedule
        $capacityLimit = $schedule === 'AM' ? $dailyCapacity->am_capacity : $dailyCapacity->pm_capacity;

        // Count the approved reservations for the selected date and schedule
        $currentCount = Reservation::where('date', $formattedDate)
            ->where('status', 'approved')
            ->where('preferred_schedule', $schedule)
            ->count();

        // If current count has reached or exceeded the limit, return an error
        if ($currentCount >= $capacityLimit) {
            return ['error' => "The selected date's {$schedule} slot has reached its maximum capacity."];
        }

        // Generate the queue number with format: YYYYMMDD-SCHEDULE-### (e.g., 20241110-AM-001)
        $queueNumber = $formattedDate . '-' . $schedule . '-' . str_pad($currentCount + 1, 3, '0', STR_PAD_LEFT);

        return ['queue_number' => $queueNumber];
    }


    // For patient
    public function userReservationList()
    {
        $patient = Patient::where('user_id', auth()->user()->id)->first();
        $userReservations = Reservation::where('patient_id', $patient->id)
                            ->orderByRaw("CASE WHEN status = 'pending' THEN 0 ELSE 1 END")
                            ->orderBy('date', 'desc')->get();

        return view('user.user-reservations', compact('userReservations'))->with('title', 'Reservations | My List');
    }


    // For admin view
    public function reservationList()
    {
        $reservations = Reservation::orderByRaw("
        CASE WHEN status = 'pending' THEN 0 ELSE 1 END
    ")->orderBy('date', 'desc')->get();
    

        return view('admin.appointments.view', compact('reservations'))->with('title', 'Reservations | View List');
    }

    public function create(Service $service)
    {
        $today = Carbon::today();
        $availableDates = DailyPatientCapacity::where('date', '>=', $today)->orderBy('date')->get();
        return view('user.reservation', compact('availableDates', 'service'))->with('title', 'Reserve Appointment');
    }

    public function store(Request $request, Service $service)
    {
        $validated = $request->validate([
            'date' => 'required|date|after_or_equal:today',
            'preferred_schedule' => 'required|in:AM,PM',
            'current_condition' => 'required|string|max:100',
        ]);
        $patient = Patient::where('user_id', Auth::user()->id)->first();

        $reservation = Reservation::create([
            'patient_id' => $patient->id,
            'service_id' => $service->id,
            'current_condition' => $validated['current_condition'],
            'preferred_schedule' => $validated['preferred_schedule'],
            'status' => 'pending',
            'date' => $validated['date']
        ]);

        if (!$reservation) {
            emotify('error', 'Reservation request failed. Please try again later.');
            return redirect()->back();
        }

        // Notify Admin that there is new reservation request
        $admins = User::where('userType', 'admin')->get();
        Notification::send($admins, new NewReservation($reservation));

        // Notify the user that their reservation request was submitted
        $user = auth()->user();
        $user->notify(new ReservationSubmitted($reservation));

        emotify('success', 'Your reservation has been requested successfully.');
        return redirect()->route('user.reservation.list');
    }

    public function update(Request $request)
    {
        // Validate the incoming request based on the presence of remarks
        $validated = $request->validate([
            'reservation_id' => 'required|exists:reservations,id',
            'status' => 'required|in:pending,approved,declined',
            'remarks' => 'nullable|string'
        ]);

        $reservation = Reservation::findOrFail($validated['reservation_id']);

        // Initialize queue number if the status is approved
        $queueNumber = null;
        if ($validated['status'] === 'approved') {
            $result = $this->generateQueueNumber($reservation->date, $reservation->preferred_schedule);

            if (isset($result['error'])) {
                emotify('error', $result['error']);
                return redirect()->back();
            }

            $queueNumber = $result['queue_number'];
        }

        // Use a transaction to ensure data integrity
        try {
            DB::transaction(function () use ($reservation, $validated, $queueNumber) {
                // Update reservation status and remarks
                $reservation->status = $validated['status'];

                if (isset($validated['remarks'])) {
                    $reservation->remarks = $validated['remarks'];
                }

                // Handle appointment creation if approved
                if ($queueNumber) {
                    $reservation->queue_number = $queueNumber;

                    Appointment::create([
                        'reservation_id' => $reservation->id,
                        'queue_number' => $queueNumber,
                        'status' => 'scheduled',
                    ]);

                    // Send email notification for approval
                    $reservation->patient->user->notify(new ApprovedReservation($reservation));
                } else {
                    // Send email notification for declined
                    $reservation->patient->user->notify(new DeclinedReservation($reservation));
                }

                $reservation->save();
            });

            emotify('success', 'Reservation status updated successfully.');
        } catch (\Exception $e) {
            emotify('error', 'An error occurred while updating the reservation.');
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }

        return redirect()->back();
    }
}
