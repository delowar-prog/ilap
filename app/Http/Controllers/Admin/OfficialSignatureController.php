<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OfficialSignature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class OfficialSignatureController extends Controller
{
    /**
     * Display a listing of official signatures & seals.
     */
    public function index(Request $request)
    {
        $query = OfficialSignature::latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('designation', 'like', "%{$search}%")
                  ->orWhere('tag_key', 'like', "%{$search}%");
            });
        }



        $signatures = $query->paginate(15);

        return view('backend.official_signatures.index', compact('signatures'));
    }

    /**
     * Helper to get system roles and common designations.
     */
    private function getDesignationRoles(): array
    {
        $dbRoles = \Spatie\Permission\Models\Role::pluck('name')->toArray();
        $commonRoles = ['Super Admin', 'Admin', 'Managing Director', 'Principal', 'Vice Principal', 'Registrar', 'Academic Dean', 'Student', 'Official Seal'];
        $merged = array_unique(array_merge($commonRoles, $dbRoles));
        sort($merged);
        return array_values($merged);
    }

    /**
     * Show form to create new official signature/seal.
     */
    public function create()
    {
        $roles = $this->getDesignationRoles();
        return view('backend.official_signatures.create', compact('roles'));
    }

    /**
     * Store new signature/seal.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'           => 'required|string|max:255',
            'designation'    => 'nullable|string|max:255',
            'tag_key'        => 'required|string|max:100|unique:official_signatures,tag_key',
            'signature_data' => 'nullable|string',
            'signature_file' => 'nullable|image|mimes:png,jpg,jpeg,webp,svg|max:5120',
            'seal_file'      => 'nullable|image|mimes:png,jpg,jpeg,webp,svg|max:5120',
        ]);

        $signaturePath = null;
        $sealPath = null;

        // Process Canvas Drawing (Base64 PNG)
        if (!empty($request->signature_data) && str_contains($request->signature_data, 'base64')) {
            $base64Image = $request->signature_data;
            if (preg_match('/^data:image\/(\w+);base64,/', $base64Image)) {
                $base64Image = substr($base64Image, strpos($base64Image, ',') + 1);
                $imageData = base64_decode($base64Image);

                $destinationPath = public_path('uploads/official_signatures');
                if (!File::exists($destinationPath)) {
                    File::makeDirectory($destinationPath, 0755, true);
                }

                $fileName = 'sig_' . time() . '_' . Str::random(6) . '.png';
                File::put($destinationPath . '/' . $fileName, $imageData);
                $signaturePath = 'uploads/official_signatures/' . $fileName;
            }
        } 
        // Or Process Uploaded Image File
        elseif ($request->hasFile('signature_file')) {
            $file = $request->file('signature_file');
            $fileName = 'sig_' . time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('uploads/official_signatures');
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }
            $file->move($destinationPath, $fileName);
            $signaturePath = 'uploads/official_signatures/' . $fileName;
        }

        // Process Seal Image File
        if ($request->hasFile('seal_file')) {
            $file = $request->file('seal_file');
            $fileName = 'seal_' . time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('uploads/official_signatures');
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }
            $file->move($destinationPath, $fileName);
            $sealPath = 'uploads/official_signatures/' . $fileName;
        }

        if (!$signaturePath && !$sealPath) {
            return back()->withInput()->withErrors(['signature_data' => 'Please provide at least a signature or a seal.']);
        }

        // Generate unique tag key
        $tagKey = Str::slug($validated['tag_key'], '_');

        OfficialSignature::create([
            'name'           => $validated['name'],
            'designation'    => $validated['designation'],
            'tag_key'        => $tagKey,
            'signature_path' => $signaturePath,
            'seal_path'      => $sealPath,
            'status'         => 'active',
            'created_by'     => auth()->id(),
        ]);

        return redirect()->route('admin.official-signatures.index')
            ->with('success', 'Official Signature created successfully.');
    }

    /**
     * Show form to edit signature/seal.
     */
    public function edit($id)
    {
        $signature = OfficialSignature::findOrFail($id);
        $roles = $this->getDesignationRoles();
        return view('backend.official_signatures.edit', compact('signature', 'roles'));
    }

    /**
     * Update existing signature/seal.
     */
    public function update(Request $request, $id)
    {
        $signature = OfficialSignature::findOrFail($id);

        $validated = $request->validate([
            'name'           => 'required|string|max:255',
            'designation'    => 'nullable|string|max:255',
            'tag_key'        => 'required|string|max:100|unique:official_signatures,tag_key,' . $id,
            'signature_data' => 'nullable|string',
            'signature_file' => 'nullable|image|mimes:png,jpg,jpeg,webp,svg|max:5120',
            'seal_file'      => 'nullable|image|mimes:png,jpg,jpeg,webp,svg|max:5120',
        ]);

        $signaturePath = $signature->signature_path;
        $sealPath = $signature->seal_path;

        // Process Canvas Drawing if provided
        if (!empty($request->signature_data) && str_contains($request->signature_data, 'base64')) {
            $base64Image = $request->signature_data;
            if (preg_match('/^data:image\/(\w+);base64,/', $base64Image)) {
                $base64Image = substr($base64Image, strpos($base64Image, ',') + 1);
                $imageData = base64_decode($base64Image);

                $destinationPath = public_path('uploads/official_signatures');
                if (!File::exists($destinationPath)) {
                    File::makeDirectory($destinationPath, 0755, true);
                }

                // Delete old image
                if (File::exists(public_path($signature->signature_path))) {
                    File::delete(public_path($signature->signature_path));
                }

                $fileName = 'sig_' . time() . '_' . Str::random(6) . '.png';
                File::put($destinationPath . '/' . $fileName, $imageData);
                $signaturePath = 'uploads/official_signatures/' . $fileName;
            }
        } 
        // Process uploaded image file if provided
        elseif ($request->hasFile('signature_file')) {
            if (File::exists(public_path($signature->signature_path))) {
                File::delete(public_path($signature->signature_path));
            }
            $file = $request->file('signature_file');
            $fileName = 'sig_' . time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('uploads/official_signatures');
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }
            $file->move($destinationPath, $fileName);
            $signaturePath = 'uploads/official_signatures/' . $fileName;
        }

        // Process uploaded seal file if provided
        if ($request->hasFile('seal_file')) {
            if ($signature->seal_path && File::exists(public_path($signature->seal_path))) {
                File::delete(public_path($signature->seal_path));
            }
            $file = $request->file('seal_file');
            $fileName = 'seal_' . time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('uploads/official_signatures');
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }
            $file->move($destinationPath, $fileName);
            $sealPath = 'uploads/official_signatures/' . $fileName;
        }

        $tagKey = Str::slug($validated['tag_key'], '_');

        $signature->update([
            'name'           => $validated['name'],
            'designation'    => $validated['designation'],
            'tag_key'        => $tagKey,
            'signature_path' => $signaturePath,
            'seal_path'      => $sealPath,
        ]);

        return redirect()->route('admin.official-signatures.index')
            ->with('success', 'Official Signature updated successfully.');
    }

    /**
     * Remove signature/seal.
     */
    public function destroy($id)
    {
        $signature = OfficialSignature::findOrFail($id);

        if ($signature->signature_path && File::exists(public_path($signature->signature_path))) {
            File::delete(public_path($signature->signature_path));
        }

        if ($signature->seal_path && File::exists(public_path($signature->seal_path))) {
            File::delete(public_path($signature->seal_path));
        }

        $signature->delete();

        return redirect()->route('admin.official-signatures.index')
            ->with('success', 'Official Signature deleted successfully.');
    }
}
