<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserCreateRequest;
use App\Models\Campus;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $isSuperAdmin = $user->hasRole('Super Admin');

        $query = User::with('campus')
            // ১. ব্রাঞ্চ রেজুল্টেশন: সুপার এডমিন না হলে শুধু নিজের ব্রাঞ্চের ইউজার দেখবে
            ->when(! $isSuperAdmin, fn ($q) => $q->where('campus_id', $user->campus_id))

            // ২. সার্চ ফিল্টার (OR কন্ডিশন গ্রুপ করা হয়েছে)
            ->when(request('search'), function ($q) {
                $search = request('search');
                $q->where(function ($subQuery) use ($search) {
                    $subQuery->where('user_first_name', 'like', "%{$search}%")
                        ->orWhere('user_last_name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })

            // ৩. ব্রাঞ্চ ফিল্টার (শুধুমাত্র সুপার এডমিনের জন্য)
            ->when($isSuperAdmin && request('campus_id'), fn ($q) => $q->where('campus_id', request('campus_id')))

            // ৪. রোল ফিল্টার
            ->when(request('role'), fn ($q) => $q->role(request('role')))

            // ৫. স্ট্যাটাস ফিল্টার
            ->when(request('status'), fn ($q) => $q->where('status', request('status')))

            // নতুন ইউজাররা আগে দেখাবে (Optional but recommended)
            ->latest();

        $users = $query->paginate(request('per_page', 10));

        // ড্রপডাউনের জন্য অপ্টিমাইজড ডেটা (শুধুমাত্র প্রয়োজনীয় কলাম লোড করা হয়েছে)
        $campuses = Campus::where('status', 'active')->select('id', 'name')->get();
        $roles = Role::where('name', '!=', 'Super Admin')->select('id', 'name')->get();

        return view('backend.users.index', compact('users', 'campuses', 'roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $currentUser = auth()->user();
        $isPrivilegedUser = $currentUser->hasRole('Super Admin') || $currentUser->hasRole('HQ Admin');

        // ব্রাঞ্চ ফিল্টারিং
        $campusesQuery = Campus::where('status', 'active');

        if (! $isPrivilegedUser) {
            $campusesQuery->where('id', $currentUser->campus_id);
        }

        $campuses = $campusesQuery->orderBy('name')->get();

        // রোল ফিল্টারিং
        $rolesQuery = Role::query();

        if ($isPrivilegedUser) {
            // Super Admin/HQ Admin: সব রোল দেখবে (Super Admin বাদে)
            $rolesQuery->where('name', '!=', 'Super Admin');
        } else {
            // ব্রাঞ্চ ইউজার: শুধু এই রোলগুলো দেখবে
            $allowedRoles = ['Campus Admin', 'Staff', 'Student'];
            $rolesQuery->whereIn('name', $allowedRoles);
        }

        $roles = $rolesQuery->orderBy('name')->get();

        return view('backend.users.create', compact('campuses', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserCreateRequest $request)
    {
        
        // DB Transaction ব্যবহার করছি যাতে ইউজার তৈরি হলে রোল অ্যাসাইনও নিশ্চিত হয়
        DB::transaction(function () use ($request) {
            // ১. ছবি আপলোড হ্যান্ডলিং
            $photoPath = null;
            if ($request->hasFile('photo')) {
                $photoPath = $request->file('photo')->store('users/photos', 'public');
            }

            // ২. ইউজার তৈরি
            $user = User::create([
                'user_first_name' => $request->user_first_name,
                'user_middle_name' => $request->user_middle_name,
                'user_last_name'  => $request->user_last_name,
                'email'           => $request->email,
                'phone'           => $request->phone,
                'photo'           => $photoPath,
                'campus_id'       => $request->campus_id,
                'password'        => Hash::make($request->password),
                'status'          => $request->status,
            ]);

            // ৩. রোল অ্যাসাইন করা (Spatie Permission)
            $user->assignRole($request->role);
        });

        return redirect()
            ->route('users.index')
            ->with('success', 'User created and role assigned successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
