<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Institute;

class InstituteController extends Controller
{
    public function index()
    {
        $institutes = Institute::latest()->paginate(10);
        return view('backend.institute.index', compact('institutes'));
    }

    public function create()
    {
        return view('backend.institute.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:100|unique:institutes,code',
            'eiin' => 'nullable|string|max:100',
            'registration_number' => 'nullable|string|max:100',
            'institute_type' => 'nullable|string|max:100',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'institute_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|url|max:255',
            'established_year' => 'nullable|integer',
            'country' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'city' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'status' => 'required|in:active,inactive'
        ]);

        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('institutes/logos', 'public');
            $validated['logo'] = 'storage/' . $logoPath;
        }

        if ($request->hasFile('institute_images')) {
            $paths = [];
            foreach ($request->file('institute_images') as $image) {
                $path = $image->store('institutes/images', 'public');
                $paths[] = 'storage/' . $path;
            }
            $validated['institute_images'] = json_encode($paths);
        }

        Institute::create($validated);

        return redirect()->route('institutes.index')->with('success', 'Institute created successfully.');
    }

    public function edit(Institute $institute)
    {
        return view('backend.institute.edit', compact('institute'));
    }

    public function update(Request $request, Institute $institute)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:100|unique:institutes,code,' . $institute->id,
            'eiin' => 'nullable|string|max:100',
            'registration_number' => 'nullable|string|max:100',
            'institute_type' => 'nullable|string|max:100',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'institute_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|url|max:255',
            'established_year' => 'nullable|integer',
            'country' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'city' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'status' => 'required|in:active,inactive'
        ]);

        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('institutes/logos', 'public');
            $validated['logo'] = 'storage/' . $logoPath;
        }

        if ($request->hasFile('institute_images')) {
            $existingPaths = $institute->institute_images ?? [];
            foreach ($request->file('institute_images') as $image) {
                $path = $image->store('institutes/images', 'public');
                $existingPaths[] = 'storage/' . $path;
            }
            $validated['institute_images'] = json_encode($existingPaths);
        }

        $institute->update($validated);

        return redirect()->route('institutes.index')->with('success', 'Institute updated successfully.');
    }

    public function destroy(Institute $institute)
    {
        $institute->delete();
        return redirect()->route('institutes.index')->with('success', 'Institute deleted successfully.');
    }
}
