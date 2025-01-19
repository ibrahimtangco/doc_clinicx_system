<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Models\DailyPatientCapacity;
use Illuminate\Database\QueryException;
use App\Http\Requests\DailyPatientCapacityRequest;

class DailyPatientCapacityController extends Controller
{
    public function index()
    {
        $dailyPatientCapacities = DailyPatientCapacity::orderBy('date')->get();

        return view('admin.daily_patient_capacity.index', compact('dailyPatientCapacities'))->with('title', 'Daily Capacities | View List');
    }

    public function create()
    {
        return view('admin.daily_patient_capacity.create')->with('title', 'Daily Capacities | Create');
    }



    public function store(DailyPatientCapacityRequest $request)
    { 
        try {
            $result = DailyPatientCapacity::create([
                'date' => $request->date,
                'am_capacity' => $request->am_capacity,
                'pm_capacity' => $request->pm_capacity,
            ]);

            if ($result) {
                emotify('success', 'Daily patient capacity entry created successfully.');
                return redirect()->route('daily-patient-capacity.index');
            }
        } catch (QueryException $e) {
            // Check if the error code is for a duplicate entry
            if ($e->errorInfo[1] == 1062) {
                emotify('error', 'An entry for this date already exists.');
                return redirect()->back();
            } else {
                emotify('error', 'Failed to create daily patient capacity entry.');
                return redirect()->route('daily-patient-capacity.index');
            }
        }
    }


    public function edit(DailyPatientCapacity $dailyPatientCapacity)
    {

        return view('admin.daily_patient_capacity.edit', compact('dailyPatientCapacity'))->with('title', 'Daily Capacities | Update Details');;
    }

    public function update(DailyPatientCapacityRequest $request, DailyPatientCapacity $dailyPatientCapacity)
    {
        try {
            $result = $dailyPatientCapacity->update([
                'date' => $request->date,
                'am_capacity' => $request->am_capacity,
                'pm_capacity' => $request->pm_capacity,
            ]);

            if ($result) {
                emotify('success', 'Daily patient capacity entry updated successfully.');
                return redirect()->route('daily-patient-capacity.index');
            } else {
                emotify('error', 'Failed to update daily patient capacity entry.');
                return redirect()->route('daily-patient-capacity.index');
            }
        } catch (QueryException $e) {
            // Check if the error code is for a duplicate entry
            if ($e->errorInfo[1] == 1062) {
                emotify('error', 'An entry for this date already exists.');
            } else {
                emotify('error', 'Failed to update daily patient capacity entry.');
            }

            return redirect()->back();
        }
    }

    public function getCapacity($date)
    {
        // Retrieve the daily capacity for the specified date
        $slot = DailyPatientCapacity::where('date', $date)->first();

        if (!$slot) {
            return response()->json(['error' => 'No capacity settings found for the selected date.'], 404);
        }

        // Count existing reservations for AM and PM schedules on the specified date
        $reservationsAM = Reservation::where('date', $date)->where('preferred_schedule', 'AM')->where('status', 'approved')->count();
        $reservationsPM = Reservation::where('date', $date)->where('preferred_schedule', 'PM')->where('status', 'approved')->count();

        $availableSlots = [];

        // Check AM capacity
        if ($slot->am_capacity > $reservationsAM) {
            $availableSlots['am_capacity'] = $slot->am_capacity - $reservationsAM;
        }

        // Check PM capacity
        if ($slot->pm_capacity > $reservationsPM) {
            $availableSlots['pm_capacity'] = $slot->pm_capacity - $reservationsPM;
        }

        // If no available slots, return an error message
        if (empty($availableSlots)) {
            return response()->json(['no_available' => 'No available slots for the selected date.']);
        }

        // Return available slots with remaining capacities
        return response()->json($availableSlots);
    }
}
