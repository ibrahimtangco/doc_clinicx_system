<?php

namespace App\Http\Controllers;

use Log;
use App\Models\Patient;
use App\Models\Provider;
use App\Models\Prescription;
use Illuminate\Http\Request;
use App\Http\Requests\StorePrescriptionRequest;
use App\Http\Requests\UpdatePrescriptionRequest;

class PrescriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $prescriptions = Prescription::orderBy('created_at', 'desc')->get();

        $userType = auth()->user()->userType;

        $view = match ($userType) {
            'admin' => 'admin.prescription.index',
            'staff' => 'admin.prescription.index',
            'superadmin' => 'super_admin.prescription.index'
        };

        return view($view, compact('prescriptions'))->with('title', 'Prescriptions | View List');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Patient $patient)
    {
        $userType = auth()->user()->userType;

        $view = match ($userType) {
            'admin' => 'admin.prescription.create',
            'superadmin' => 'super_admin.prescription.create'
        };

        return view($view, ['patient' => $patient])->with('title', 'Prescription | Write Prescription');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePrescriptionRequest $request)
    {
        $validated = $request->validated();
        $medicines = [];
        $quantities = [];
        $dosages = [];

        foreach ($validated['inputs'] as $item) {
            array_push($medicines, $item['medicine_name']);
            array_push($quantities, $item['quantity']);
            array_push($dosages, $item['dosage']);
        }

        $provider = Provider::where('user_id', auth()->user()->id)->first();

        if (!$provider) {
            emotify('error', 'Something went wrong. Try again later');
            return redirect()->back();
        }

        $prescription = Prescription::create([
            'patient_id' => $validated['patient_id'],
            'provider_id' => $provider->id,
            'medicines' => $medicines,
            'quantities' => $quantities,
            'dosages' => $dosages,
        ]);

        $userType = auth()->user()->userType;

        $route = match ($userType) {
            'admin' => 'admin.prescriptions.index',
            'staff' => 'admin.prescriptions.index',
            'superadmin' => 'superadmin.prescriptions.index'
        };

        if (!$prescription) {
            emotify('error', 'Failed to create prescription');
            return redirect()->route($route);
        }
        emotify('success', 'Prescription created successfully');
        return redirect()->route($route);
    }

    /**
     * Display the specified resource.
     */
    public function show(Prescription $prescription)
    {
        $userType = auth()->user()->userType;

        $view = match ($userType) {
            'admin' => 'admin.prescription.print_preview',
            'staff' => 'admin.prescription.print_preview',
            'superadmin' => 'superadmin.prescription.print_preview'
        };
        return view($view, ['prescription' => $prescription])->with('title', 'Prescription | View as PDF');
    }
}
