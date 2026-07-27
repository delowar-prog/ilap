<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CampusType;
use Illuminate\Http\Request;

class CampusTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $campusTypes = CampusType::latest()->paginate(10);
        return view('backend.campus_types.index', compact('campusTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.campus_types.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:campus_types,name',
            'status' => 'required|in:active,inactive',
        ]);

        CampusType::create($request->all());

        return redirect()->route('admin.campus-types.index')->with('success', 'Campus Type created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CampusType $campusType)
    {
        return view('backend.campus_types.edit', compact('campusType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CampusType $campusType)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:campus_types,name,' . $campusType->id,
            'status' => 'required|in:active,inactive',
        ]);

        $campusType->update($request->all());

        return redirect()->route('admin.campus-types.index')->with('success', 'Campus Type updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CampusType $campusType)
    {
        $campusType->delete();
        return redirect()->route('admin.campus-types.index')->with('success', 'Campus Type deleted successfully.');
    }
}
