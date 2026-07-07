<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Models\Campus;
use App\Models\Country;
use App\Models\Student;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $campuses  = Campus::active()->orderBy('name')->get();
        $countries = Country::orderBy('name')->get();
        return view('auth.register', compact('campuses', 'countries'));
    }

    /**
     * Handle student registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'first_name'  => ['required', 'string', 'max:100'],
            'middle_name' => ['nullable', 'string', 'max:100'],
            'surname'     => ['required', 'string', 'max:100'],
            'email'       => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'phone'       => ['required', 'string', 'max:20'],
            'password'    => ['required', 'confirmed', Rules\Password::defaults()],
            'campus_id'   => ['required', 'exists:campuses,id'],
            'country_id'  => ['required', 'exists:countries,id'],
            'promo_code'  => ['nullable', 'string', 'max:50'],
        ]);

        // Resolve agent via promo_code (optional)
        $agent    = null;
        $agentId  = null;
        if ($request->filled('promo_code')) {
            $agent   = Agent::where('agent_code', strtoupper($request->promo_code))->first();
            $agentId = $agent?->id;
        }

        DB::transaction(function () use ($request, $agentId) {
            // 1. Create the User account (users table uses user_first_name, user_last_name)
            $user = User::create([
                'user_first_name' => $request->first_name,
                'user_last_name'  => $request->surname,
                'email'           => $request->email,
                'password'        => Hash::make($request->password),
                'phone'           => $request->phone,
            ]);
            $user->assignRole('Student');

            // 2. Generate unique student_id e.g. STU-20250706-XXXX
            $studentId = 'STU-' . now()->format('Ymd') . '-' . strtoupper(Str::random(4));

            // 3. Create the Student profile linked to this user
            $student = Student::create([
                'user_id'     => $user->id,
                'campus_id'   => $request->campus_id,
                'country_id'  => $request->country_id,
                'agent_id'    => $agentId,
                'student_id'  => $studentId,
                'promo_code'  => $request->promo_code ? strtoupper($request->promo_code) : null,
                'first_name'  => $request->first_name,
                'middle_name' => $request->middle_name,
                'surname'     => $request->surname,
                'email'       => $request->email,
                'phone'       => $request->phone,
                'status'      => 'incomplete',
            ]);

            event(new Registered($user));
            Auth::login($user);
        });

        // Redirect to pre-assessment form after registration
        return redirect()->route('pre.assessment.show')
            ->with('success', 'Registration successful! Please complete the pre-assessment form.');
    }
}
