<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function index()
    {
        $countries = Country::when(request('search'), function ($q) {
                $q->where('name', 'like', '%' . request('search') . '%')
                  ->orWhere('iso2', 'like', '%' . request('search') . '%');
            })
            ->when(request('status'), fn($q) => $q->where('status', request('status')))
            ->latest()
            ->paginate(15);

        return view('backend.countries.index', compact('countries'));
    }

    public function create()
    {
        return view('backend.countries.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:countries,name',
            'iso2' => 'nullable|string|max:2|unique:countries,iso2',
            'iso3' => 'nullable|string|max:3|unique:countries,iso3',
            'phone_code' => 'nullable|string|max:10',
            'currency' => 'nullable|string|max:10',
            'currency_symbol' => 'nullable|string|max:10',
            'capital' => 'nullable|string|max:100',
            'status' => 'required|in:active,inactive',
        ]);

        Country::create($validated);

        return redirect()->route('countries.index')
            ->with('success', 'Country created successfully.');
    }

    public function edit($id)
    {
        $country = Country::findOrFail($id);
        return view('backend.countries.edit', compact('country'));
    }

    public function update(Request $request, $id)
    {
        $country = Country::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:countries,name,' . $country->id,
            'iso2' => 'nullable|string|max:2|unique:countries,iso2,' . $country->id,
            'iso3' => 'nullable|string|max:3|unique:countries,iso3,' . $country->id,
            'phone_code' => 'nullable|string|max:10',
            'currency' => 'nullable|string|max:10',
            'currency_symbol' => 'nullable|string|max:10',
            'capital' => 'nullable|string|max:100',
            'status' => 'required|in:active,inactive',
        ]);

        $country->update($validated);

        return redirect()->route('countries.index')
            ->with('success', 'Country updated successfully.');
    }

    public function destroy($id)
    {
        $country = Country::findOrFail($id);
        
        if ($country->states()->count() > 0) {
            return back()->with('error', 'Cannot delete! This country has states.');
        }

        $country->delete();

        return redirect()->route('countries.index')
            ->with('success', 'Country deleted successfully.');
    }
}