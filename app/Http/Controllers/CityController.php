<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;
use App\Models\State;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function index()
    {
        $cities = City::with(['country', 'state'])
            ->when(request('search'), function ($q) {
                $q->where('name', 'like', '%' . request('search') . '%');
            })
            ->when(request('country_id'), fn($q) => $q->where('country_id', request('country_id')))
            ->when(request('state_id'), fn($q) => $q->where('state_id', request('state_id')))
            ->when(request('status'), fn($q) => $q->where('status', request('status')))
            ->latest()
            ->paginate(15);

        $countries = Country::where('status', 'active')->select('id', 'name')->get();

        return view('backend.cities.index', compact('cities', 'countries'));
    }

    public function create()
    {
        $countries = Country::where('status', 'active')->select('id', 'name')->get();
        return view('backend.cities.create', compact('countries'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'country_id' => 'required|exists:countries,id',
            'state_id' => 'required|exists:states,id',
            'name' => 'required|string|max:100',
            'city_code' => 'nullable|string|max:10',
            'status' => 'required|in:active,inactive',
        ]);

        City::create($validated);

        return redirect()->route('cities.index')
            ->with('success', 'City created successfully.');
    }

    public function edit($id)
    {
        $city = City::findOrFail($id);
        $countries = Country::where('status', 'active')->select('id', 'name')->get();
        $states = State::where('country_id', $city->country_id)
            ->where('status', 'active')
            ->select('id', 'name')
            ->get();
        return view('backend.cities.edit', compact('city', 'countries', 'states'));
    }

    public function update(Request $request, $id)
    {
        $city = City::findOrFail($id);

        $validated = $request->validate([
            'country_id' => 'required|exists:countries,id',
            'state_id' => 'required|exists:states,id',
            'name' => 'required|string|max:100',
            'city_code' => 'nullable|string|max:10',
            'status' => 'required|in:active,inactive',
        ]);

        $city->update($validated);

        return redirect()->route('cities.index')
            ->with('success', 'City updated successfully.');
    }

    public function destroy($id)
    {
        $city = City::findOrFail($id);
        $city->delete();

        return redirect()->route('cities.index')
            ->with('success', 'City deleted successfully.');
    }

    // AJAX API for Dependent Dropdown
    public function getStatesByCountry($countryId)
    {
        $states = State::where('country_id', $countryId)
            ->where('status', 'active')
            ->select('id', 'name')
            ->orderBy('name')
            ->get();

        return response()->json($states);
    }

    public function getCitiesByState($stateId)
    {
        $cities = City::where('state_id', $stateId)
            ->where('status', 'active')
            ->select('id', 'name')
            ->orderBy('name')
            ->get();

        return response()->json($cities);
    }
}