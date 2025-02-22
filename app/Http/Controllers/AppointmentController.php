<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Appointment;
use App\Notifications\CompletedAppointment;
use Illuminate\Http\Request;
use App\Notifications\NoShowAppointment;
use Illuminate\Database\Eloquent\Builder;


class AppointmentController extends Controller
{

    // Super admin | Appointment List
    public function index()
    {
        $appointments = Appointment::with(['reservation.user', 'reservation.patient', 'reservation.service'])
            ->orderByRaw("CASE
                            WHEN status = 'scheduled' THEN 1
                            ELSE 2
                        END")
            ->get();


        return view('super_admin.appointments.view', compact('appointments'))->with('title', 'Appointments | View List');
    }

    public function myServiceHistories()
    {
        $user = auth()->user();

        $myServiceHistories = Appointment::join('reservations', 'appointments.reservation_id', '=', 'reservations.id')
            ->where('reservations.patient_id', $user->patient->id)
            ->where('appointments.status', 'completed')
            ->select('appointments.*') // Select appointment columns
            ->get();

        return view('user.user-service-histories', compact('myServiceHistories'))->with('title', 'Service Histories | View List');
    }
    public function userAppointmentList()
    {
        $user = auth()->user(); // Get the authenticated user

        $appointments = Appointment::with(['reservation.service', 'reservation.patient'])
            ->whereHas('reservation.patient', function (Builder $query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->join('reservations', 'appointments.reservation_id', '=', 'reservations.id') // Join the reservations table
            ->orderByRaw("CASE WHEN appointments.status = 'scheduled' THEN 0 ELSE 1 END")
            ->orderBy('reservations.date', 'desc') // Use reservations.date for ordering
            ->select('appointments.*') // Ensure only appointment columns are selected
            ->get();


        return view('user.user-appointments', compact('appointments'))->with('title', 'Appointments | View List');
    }
    public function indexAdmin()
    {
        $appointments = Appointment::with(['reservation.user', 'reservation.patient', 'reservation.service'])
            ->orderByRaw("CASE
                        WHEN status = 'scheduled' THEN 1
                        ELSE 2
                    END")
            ->get();

        return view('admin.appointments.view-appointments', compact('appointments'))->with('title', 'Appointments | View List');
    }

    // Super admin
    public function viewAppointmentDetails(Appointment $appointment)
    {

        return view('super_admin.appointments.appointment-details', compact('appointment'))->with('title', 'Appointment | View Details');
    }

    public function viewAppointmentDetailsAdmin(Appointment $appointment)
    {

        return view('admin.appointments.appointment-details', compact('appointment'))->with('title', 'Appointment | View Details');
    }

    // Update status
    public function update(Request $request)
    {
        $validated = $request->validate([
            'appointment_id' => 'required|exists:appointments,id',
            'patient_id' => 'required|exists:patients,id',
            'status' => 'required|in:scheduled,completed,no_show',
            'remarks' => 'nullable|string|max:75',
            'write_prescription' => 'sometimes',
        ]);

        $appointment = Appointment::findOrFail($validated['appointment_id']);

        // Update appointment status and remark
        $appointment->update([
            'status' => $validated['status'],
            'remarks' => $validated['remarks'],
        ]);

        // Notify patient based on the status
        if (in_array($validated['status'], ['completed', 'no_show'])) {
            // Update appointment status and remarks
            $notificationClass = $validated['status'] === 'completed' ? CompletedAppointment::class : NoShowAppointment::class;
            $appointment->reservation->patient->user->notify(new $notificationClass($appointment));
        }

        if (isset($validated['write_prescription'])) {
            $patient = Patient::findOrFail($validated['patient_id']);

            emotify('success', 'Appointment status updated successfully.');
            return redirect()->route('create.prescription', ['patient' => $patient]);
        }

        emotify('success', 'Appointment status updated successfully.');
        return redirect()->back();
    }
}
