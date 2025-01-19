<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use App\Http\Requests\StoreServiceRequest;
use App\Http\Requests\UpdateServiceRequest;

class ServiceController extends Controller
{

    protected $serviceModel;

    function __construct(Service $serviceModel)
    {
        $this->serviceModel = $serviceModel;
    }

    public function display()
    {
        $services = Service::where('availability', 1)->get();
        // dd($services);
        return view('user/dashboard', ['services' => $services])->with('title', 'Available Services');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = Service::all();
        // dd($services);
        return view('admin.services.index', compact('services'))->with('title', 'Services | View List');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.services.create')->with('title', 'Services | Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreServiceRequest $request)
    {
        $validated = $request->validated();
        $service = $this->serviceModel->storeServicedetails($validated);

        if (!$service) {
            emotify('error', 'Failed to add service');
            return redirect()->route('services.index');
        }

        emotify('success', 'Service added successfully');
        return redirect()->route('services.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Service $service)
    {
        return view('admin.services.edit', ['service' => $service])->with('title', 'Service | Update Details');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateServiceRequest $request, Service $service)
    {
        $validated = $request->validated();

        $service = $this->serviceModel->updateServiceDetails($validated, $service->id);

        if (!$service) {
            emotify('error', 'Failed to update service');
            return redirect()->route('services.index');
        }

        emotify('success', 'Service information has been updated');
        return redirect()->route('services.index');
    }

    /**
     * Remove the specified resource from storage.
     */
}
