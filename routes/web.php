<?php

use App\Http\Controllers\frontend\frontendController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Lab404\Impersonate\Controllers\ImpersonateController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/',[frontendController::class ,'index'])->name('index');

// AJAX: Verify promo/referral code during registration
Route::get('/verify-promo', function (\Illuminate\Http\Request $request) {
    $code  = strtoupper(trim($request->query('code', '')));
    
    // First, check if it's an Agent code
    $agent = \App\Models\Agent::where('agent_code', $code)->first();
    if ($agent) {
        return response()->json([
            'found'      => true,
            'agent_name' => $agent->full_name ?? $agent->name,
        ]);
    }
    
    // Next, check if it's a User referral code
    $user = \App\Models\User::where('referral_code', $code)->first();
    if ($user) {
        return response()->json([
            'found'      => true,
            'agent_name' => trim(($user->user_first_name ?? '') . ' ' . ($user->user_last_name ?? '')),
        ]);
    }

    return response()->json(['found' => false]);
})->name('verify.promo');

// AJAX: Verify campus code during registration
Route::get('/verify-campus', function (\Illuminate\Http\Request $request) {
    $code   = strtoupper(trim($request->query('code', '')));
    $campus = \App\Models\Campus::where('campus_code', $code)->first();

    if ($campus) {
        return response()->json([
            'found'       => true,
            'campus_name' => $campus->name,
        ]);
    }
    return response()->json(['found' => false]);
})->name('verify.campus');



// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
require __DIR__.'/backend.php';
// Impersonation Routes
Route::post('/custom-impersonate-leave', function () {
    $adminId = Session::get('impersonated_by');

    if (! $adminId) {
        abort(403, 'Impersonation session not found.');
    }

    Auth::loginUsingId($adminId);

    Session::forget('impersonated_by');

    return redirect()->route('dashboard'); 

})->middleware(['web', 'auth'])->name('impersonate.leave.custom');
