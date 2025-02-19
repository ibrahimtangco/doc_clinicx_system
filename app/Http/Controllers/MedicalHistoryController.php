<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\Patient;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Models\MedicalHistory;
use Illuminate\Support\Facades\Log;
use Spatie\Browsershot\Browsershot;
use App\Http\Requests\CreateMedicalHistoryRequest;
use App\Http\Requests\UpdateMedicalHistoryRequest;

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
        // Query to retrieve appointments for the specified patient with status 'completed'
        $serviceHistories = Appointment::join('reservations', 'appointments.reservation_id', '=', 'reservations.id')
            ->where('reservations.patient_id', $patient->id)
            ->where('appointments.status', 'completed')
            ->select('appointments.*') // Select appointment columns
            ->paginate(10);

        $view = match (auth()->user()->userType) {
            'admin' => 'admin.patients.show',
            'staff' => 'admin.patients.show',
            'superadmin' => 'super_admin.patients.show'
        };
        return view($view, compact('patient', 'medicalHistories', 'serviceHistories'))->with('title', 'Patient | View Information');
    }

    public function store(CreateMedicalHistoryRequest $request)
    {
        try {
            $validatedData = $request->validated();
            $result = $this->medicalHistoryModel->storeMedicalHistory($validatedData);

            if (!$result) {
                emotify('error', 'Failed to add medical history');
                return redirect()->route('superadmin.show.patient.record', $validatedData['patient_id']);
            }
            emotify('success', 'Medical history added successfully');
            return redirect()->route('superadmin.show.patient.record', $validatedData['patient_id']);
        } catch (Exception $e) {
            // Log the error
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function update(UpdateMedicalHistoryRequest $request)
    {
        try {
            $validatedData = $request->validated();
            // dd($validatedData);
            // Attempt to update the medical history
            $result = $this->medicalHistoryModel->updateMedicalHistory($validatedData);

            if ($result) {
                emotify('success', 'Medical history was updated successfully');
            } else {
                emotify('error', 'Medical history not found or update failed');
            }

            return redirect()->back();
        } catch (Exception $e) {
            // Log the error for debugging
            Log::error('Error updating medical history: ' . $e->getMessage());

            emotify('error', 'Something went wrong. Please try again later.');
            return redirect()->back();
        }
    }

    public function downloadServiceHistories(Request $request, Patient $patient)
    {
        // Validate input
        $validated = $request->validate([
            'start' => 'nullable|date_format:m/d/Y',
            'end' => 'nullable|date_format:m/d/Y',
        ]);

        $fromDate = $validated['start'] ?? null;
        $toDate = $validated['end'] ?? null;

        // Convert date formats if provided
        $start = $fromDate ? Carbon::createFromFormat('m/d/Y', $fromDate)->startOfDay() : null;
        $end = $toDate ? Carbon::createFromFormat('m/d/Y', $toDate)->endOfDay() : null;

        // Query appointments with a SINGLE JOIN
        $query = Appointment::join('reservations', 'appointments.reservation_id', '=', 'reservations.id')
            ->where('reservations.patient_id', $patient->id)
            ->where('appointments.status', 'completed')
            ->select('appointments.*');

        // Apply date filters
        if ($start) {
            $query->where('appointments.created_at', '>=', $start);
        }
        if ($end) {
            $query->where('appointments.created_at', '<=', $end);
        }

        // Retrieve service histories
        $serviceHistories = $query->get();

        // Handle missing transactions gracefully
        if ($serviceHistories->isEmpty()) {
            emotify('error', 'No service history found for the specified date range.');
            return redirect()->back();
        }

        try {
            // Load clinic logo
            $path = public_path('images/FILARCA.png');
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $data = file_get_contents($path);
            $src = 'data:image/' . $type . ';base64,' . base64_encode($data);

            // Generate HTML for PDF
            $html = view('reports_template.patient_service_histories', [
                'imageSrc' => $src,
                'serviceHistories' => $serviceHistories,
                'patientName' => $patient->user->full_name,
                'fromDate' => $fromDate,
                'toDate' => $toDate
            ])->render();

            // Generate file name
            $patientNameExt = $patient->user->first_name . '_' . $patient->user->last_name;
            $pdfPath = public_path('FR_' . $patientNameExt . '_service_histories.pdf');

            // Generate PDF
            Browsershot::html($html)
                ->margins(15.4, 15.4, 15.4, 15.4)
                ->showBackground()
                ->save($pdfPath);

            // Download file and redirect after download
            return response()->download($pdfPath)->deleteFileAfterSend(true);
        } catch (\Exception $e) {
            emotify('error', 'An error occurred while generating the PDF: ' . $e->getMessage());
            return redirect()->back();
        }
    }
}
