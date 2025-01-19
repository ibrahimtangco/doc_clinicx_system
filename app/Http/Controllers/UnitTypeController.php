<?php

namespace App\Http\Controllers;

use App\Models\UnitType;
use Illuminate\Http\Request;

class UnitTypeController extends Controller
{

    public function index()
    {
        $unitTypes = UnitType::all();
        return view('admin.unit_types.index', compact('unitTypes'))->with('title', 'Unit of Meas. | View List');
    }

    public function create()
    {
        return view('admin.unit_types.create')->with('title', 'Unit of Meas. | Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:unit_types,name',
            'abbreviation' => 'required|string|max:10|unique:unit_types,abbreviation',
        ]);

        $result = UnitType::create($validated);

        if (!$result) {
            emotify('error', 'Failed to create product\'s unit type.');
            return redirect()->route('unit-types.index');
        }

        emotify('success', 'Product\'s unit type created successfully.');
        return redirect()->route('unit-types.index');
    }

    public function edit(UnitType $unitType)
    {
        return view('admin.unit_types.edit', compact('unitType'))->with('title', 'Unit of Meas. | Update Details');
    }

    public function update(Request $request, UnitType $unitType)
    {
        $request->merge(['availability' => $request->has('availability') ? true : false]);

        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'abbreviation' => 'required|string|max:10',
            'availability' => 'required|boolean'
        ]);

        $result = $unitType->update($validated);

        if (!$result) {
            emotify('error', 'Failed to update product\'s unit type details.');
            return redirect()->route('unit-types.index');
        }

        emotify('success', 'Product\'s unit type created successfully.');
        return redirect()->route('unit-types.index');
    }
}
