<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateMedicalHistoryRequest;
use App\Http\Requests\UpdateMedicalHistoryRequest;
use App\Models\AppointmentHistory;
use App\Models\MedicalHistory;
use App\Models\Patient;
use Exception;

class MedicalHistoryController extends Controller
{
    protected $medicalHistoryModel;

    function __construct()
    {
        $this->medicalHistoryModel = new MedicalHistory();
    }

    public function show(Patient $patient)
    {
        $medicalHistories = $this->medicalHistoryModel->showUserMedicalHistory($patient);
        $serviceHistories = AppointmentHistory::where('user_id', $patient->user->id)->where('status', 'completed')->paginate(5);

        $view = match (auth()->user()->userType) {
            'admin' => 'admin.patients.show',
            'SuperAdmin' => 'super_admin.patients.show'
        };
        return view($view, compact('patient', 'medicalHistories', 'serviceHistories'));
    }

    public function store(CreateMedicalHistoryRequest $request)
    {
        try {
            $validatedData = $request->validated();
            $result = $this->medicalHistoryModel->storeMedicalHistory($validatedData);

            $view = match (auth()->user()->userType) {
                'admin' => 'show.patient.record',
                'SuperAdmin' => 'superadmin.show.patient.record'
            };

            if (!$result) {
                emotify('error', 'Failed to add medical history');
                return redirect()->route($view, $validatedData['patient_id']);
            }
            emotify('success', 'Medical history added successfully');
            return redirect()->route($view, $validatedData['patient_id']);
        } catch (Exception $e) {
            // Log the error
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function update(UpdateMedicalHistoryRequest $request, Patient $patient)
    {
        try {
            $validatedData = $request->validated();
            $result = $this->medicalHistoryModel->updateMedicalHistory($validatedData, $patient);
            $view = match (auth()->user()->userType) {
                'admin' => 'show.patient.record',
                'SuperAdmin' => 'superadmin.show.patient.record'
            };
            if (!$result) {
                emotify('error', 'Failed to update medical history');
                return redirect()->route($view, $patient);
            }
            emotify('success', 'Medical history was updated successfully');
            return redirect()->route($view, $patient);
        } catch (Exception $e) {
            // Log the error
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
