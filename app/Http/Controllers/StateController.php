<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\State;
use App\Models\Country;
use Illuminate\Http\Request;

class StateController extends Controller
{
    public function index()
    {
        $states = State::with('country')
            ->when(request('search'), function ($q) {
                $q->where('name', 'like', '%' . request('search') . '%');
            })
            ->when(request('country_id'), fn($q) => $q->where('country_id', request('country_id')))
            ->when(request('status'), fn($q) => $q->where('status', request('status')))
            ->latest()
            ->paginate(15);

        $countries = Country::where('status', 'active')->select('id', 'name')->get();

        return view('backend.states.index', compact('states', 'countries'));
    }

    public function create()
    {
        $countries = Country::where('status', 'active')->select('id', 'name')->get();
        return view('backend.states.create', compact('countries'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'country_id' => 'required|exists:countries,id',
            'name' => 'required|string|max:100',
            'state_code' => 'nullable|string|max:10',
            'type' => 'nullable|string|max:50',
            'status' => 'required|in:active,inactive',
        ]);

        State::create($validated);

        return redirect()->route('states.index')
            ->with('success', 'State created successfully.');
    }

    public function edit($id)
    {
        $state = State::findOrFail($id);
        $countries = Country::where('status', 'active')->select('id', 'name')->get();
        return view('backend.states.edit', compact('state', 'countries'));
    }

    public function update(Request $request, $id)
    {
        $state = State::findOrFail($id);

        $validated = $request->validate([
            'country_id' => 'required|exists:countries,id',
            'name' => 'required|string|max:100',
            'state_code' => 'nullable|string|max:10',
            'type' => 'nullable|string|max:50',
            'status' => 'required|in:active,inactive',
        ]);

        $state->update($validated);

        return redirect()->route('states.index')
            ->with('success', 'State updated successfully.');
    }

    public function destroy($id)
    {
        $state = State::findOrFail($id);
        
        if ($state->cities()->count() > 0) {
            return back()->with('error', 'Cannot delete! This state has cities.');
        }

        $state->delete();

        return redirect()->route('states.index')
            ->with('success', 'State deleted successfully.');
    }
}