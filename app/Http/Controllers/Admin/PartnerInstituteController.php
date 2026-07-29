<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PartnerInstitute;
use Illuminate\Http\Request;

class PartnerInstituteController extends Controller
{
    public function index()
    {
        $options = PartnerInstitute::orderBy('name')->get();
        return view('backend.config.partner_institutes.index', compact('options'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:partner_institutes,name',
            'country' => 'nullable|string|max:100',
            'website' => 'nullable|url|max:255',
        ]);

        PartnerInstitute::create([
            'name' => $request->name,
            'country' => $request->country,
            'website' => $request->website,
            'is_active' => true,
        ]);

        return back()->with('success', "Partner Institute \"{$request->name}\" added successfully.");
    }

    public function update(Request $request, PartnerInstitute $partnerInstitute)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:partner_institutes,name,' . $partnerInstitute->id,
            'country' => 'nullable|string|max:100',
            'website' => 'nullable|url|max:255',
            'is_active' => 'nullable|boolean',
        ]);

        $partnerInstitute->update([
            'name' => $request->name,
            'country' => $request->country,
            'website' => $request->website,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return back()->with('success', 'Partner Institute updated successfully.');
    }

    public function toggle(PartnerInstitute $partnerInstitute)
    {
        $partnerInstitute->update(['is_active' => !$partnerInstitute->is_active]);

        if (request()->wantsJson() || request()->ajax()) {
            return response()->json([
                'success' => true,
                'is_active' => (bool) $partnerInstitute->is_active,
                'message' => 'Status updated successfully.'
            ]);
        }

        $state = $partnerInstitute->is_active ? 'enabled' : 'disabled';
        return back()->with('success', "Partner Institute \"{$partnerInstitute->name}\" has been {$state}.");
    }

    public function destroy(PartnerInstitute $partnerInstitute)
    {
        $name = $partnerInstitute->name;
        $partnerInstitute->delete();

        return back()->with('success', "Partner Institute \"{$name}\" deleted successfully.");
    }
}
