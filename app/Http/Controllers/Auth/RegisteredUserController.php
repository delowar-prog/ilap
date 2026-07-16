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
    public function create($userid = null): View
    {
        $campuses  = Campus::active()->orderBy('name')->get();
        $countries = Country::orderBy('name')->get();

        $refCampusCode = null;
        $refPromoCode = null;

        if ($userid) {
            $referrer = User::with(['campus', 'student.campus'])->find($userid);
            if ($referrer) {
                $refPromoCode = $referrer->referral_code;
                if ($referrer->campus) {
                    $refCampusCode = $referrer->campus->campus_code;
                } elseif ($referrer->student && $referrer->student->campus) {
                    $refCampusCode = $referrer->student->campus->campus_code;
                }
            }
        }

        return view('auth.register', compact('campuses', 'countries', 'refCampusCode', 'refPromoCode'));
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
            'email'       => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email', 'confirmed'],
            'phone_code'  => ['required', 'string'],
            'phone'       => ['required', 'string', 'max:20'],
            'password'    => ['required', 'confirmed', Rules\Password::defaults()],
            'campus_code' => ['required', 'string', 'exists:campuses,campus_code'],
            'country_id'  => ['required', 'exists:countries,id'],
            'promo_code'  => ['required', 'string', 'max:50'],
        ]);

        $fullPhone = $request->phone_code . ' ' . $request->phone;

        // Resolve agent via promo_code (optional)
        $agent    = null;
        $agentId  = null;
        if ($request->filled('promo_code')) {
            $agent   = Agent::where('agent_code', strtoupper($request->promo_code))->first();
            $agentId = $agent?->id;
        }

        // Resolve campus via campus_code
        $campus = Campus::where('campus_code', strtoupper($request->campus_code))->firstOrFail();
        $campusId = $campus->id;
        $campusCodeStr = $campus->campus_code;

        DB::transaction(function () use ($request, $fullPhone, $agentId, $campusId, $campusCodeStr) {
            // Generate unique referral code for the new user
            $myReferralCode = 'PRM' . strtoupper(Str::random(6)) . mt_rand(10, 99);

            // 1. Create the User account (users table uses user_first_name, user_last_name)
            $user = User::create([
                'user_first_name' => $request->first_name,
                'user_last_name'  => $request->surname,
                'email'           => $request->email,
                'password'        => Hash::make($request->password),
                'phone'           => $fullPhone,
                'campus_id'       => $campusId,
                'referral_code'   => $myReferralCode,
            ]);
            $user->assignRole('Student');

            // 2. Generate unique Applicant ID initially
            $yearMonth = date('ym'); // e.g. 2607 for July 2026
            $count = \App\Models\Student::whereYear('created_at', date('Y'))->whereMonth('created_at', date('m'))->count() + 1;
            $serial = str_pad($count, 2, '0', STR_PAD_LEFT);
            $initialFirstName = strtoupper(substr($request->first_name, 0, 1));
            $initialLastName  = strtoupper(substr($request->surname, 0, 1));
            $studentId = 'APP' . $yearMonth . $serial . $initialFirstName . $initialLastName;

            // 3. Create the Student profile linked to this user
            $student = Student::create([
                'user_id'     => $user->id,
                'campus_id'   => $campusId,
                'country_id'  => $request->country_id,
                'agent_id'    => $agentId,
                'student_id'  => $studentId,
                'promo_code'  => $request->promo_code ? strtoupper($request->promo_code) : null,
                'first_name'  => $request->first_name,
                'middle_name' => $request->middle_name,
                'surname'     => $request->surname,
                'email'       => $request->email,
                'phone'       => $fullPhone,
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
