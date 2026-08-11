<?php

namespace App\Http\Controllers;

use App\Http\Requests\CampusCreateRequest;
use App\Models\Campus;
use App\Models\DropdownOption;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CampusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $campuses = Campus::query()

    // Branch User only own branch
            ->when(! auth()->user()->hasRole('Super Admin'), function ($q) {
                $q->where('id', auth()->user()->campus_id);
            })
            ->when(request('search'), function ($q) {
                $q->where(function ($query) {
                    $query->where('name', 'like', '%'.request('search').'%')
                        ->orWhere('campus_code', 'like', '%'.request('search').'%')
                        ->orWhere('city', 'like', '%'.request('search').'%');
                });
            })
            ->when(request('country'), function ($q) {
                $q->where('country', request('country'));
            })
            ->when(request('status') !== null, function ($q) {
                $q->where('status', request('status'));
            });

        $sortDir = request('sort_dir', 'desc') === 'asc' ? 'asc' : 'desc';
        $campuses = $campuses->orderBy('id', $sortDir)->paginate(request('per_page', 10))->withQueryString();

        $countries = Campus::query()
            ->when(! auth()->user()->hasRole('Super Admin'), function ($q) {
                $q->where('id', auth()->user()->campus_id);
            })
            ->select('country')
            ->distinct()
            ->pluck('country');

        return view('backend.campus.index', compact('campuses', 'countries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $lastCampusNumber = Campus::latest('campus_number')->value('campus_number') ?? 0;
        $nextCampusNumber = $lastCampusNumber + 1;
        $campusTypes = DropdownOption::active('campus_type');
        return view('backend.campus.create', compact('nextCampusNumber', 'campusTypes'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CampusCreateRequest $request)
    {
        DB::transaction(function () use ($request) {

            $campus = Campus::create(array_merge($request->safe()->only([
                'campus_type', 'campus_code', 'name', 'country', 'state', 'city', 'post_code', 'address', 'phone', 'website_link', 'note', 'logo', 'currency', 'timezone',
            ]), [
                'email' => $request->campus_email,
            ]));

            $user = User::create([
                'user_first_name'  => $request->user_first_name,
                'user_middle_name' => $request->user_middle_name,
                'user_last_name'   => $request->user_last_name,
                'email'            => $request->user_email,
                'phone'            => $request->user_phone,
                'password'         => Hash::make($request->password),
                'campus_id'        => $campus->id,
            ]);

            $user->assignRole('Campus Head');
        });

        return redirect()
            ->route('campuses.index')
            ->with('success', 'Campus and Campus Admin created successfully.');
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
    public function destroy(Campus $campus)
    {
        try {
            $campus->delete();

            return redirect()
                ->route('campuses.index')
                ->with('success', 'Campus deleted successfully.');

        } catch (\Exception $e) {

            return redirect()
                ->route('campuses.index')
                ->with('error', 'Something went wrong while deleting campus.');
        }
    }
}
