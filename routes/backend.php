<?php

use App\Http\Controllers\AgentController;
use App\Http\Controllers\AgentCommissionController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\CampusController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\InstituteController;
use App\Http\Controllers\Student\StudentProfileController;
use Illuminate\Support\Facades\Route;
use Lab404\Impersonate\Controllers\ImpersonateController;

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'dashboard'])
        ->name('dashboard');
    Route::resource('permissions', PermissionController::class);
    Route::resource('roles', RoleController::class);
    Route::get('/roles/{role}/permissions', [RoleController::class, 'editPermissions'])->name('roles.permissions');
    Route::put('/roles/{role}/permissions', [RoleController::class, 'updatePermissions'])->name('roles.permissions.update');
    Route::resource('countries', CountryController::class);
    Route::resource('states', StateController::class);
    Route::resource('cities', CityController::class);
    Route::resource('campuses', CampusController::class);
    Route::resource('users', UserController::class);
    Route::resource('agents', AgentController::class);
    Route::resource('commissions', AgentCommissionController::class);
    Route::resource('courses', CourseController::class);
    Route::resource('institutes', InstituteController::class);
});

// ==================== Student Profile Routes ====================
Route::middleware(['auth'])->prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard', [StudentProfileController::class, 'dashboard'])->name('dashboard');
    Route::post('/profile/personal', [StudentProfileController::class, 'updatePersonal'])->name('profile.personal');
    Route::post('/profile/academic', [StudentProfileController::class, 'updateAcademic'])->name('profile.academic');
    Route::post('/profile/english', [StudentProfileController::class, 'updateEnglish'])->name('profile.english');
    Route::post('/profile/preferences', [StudentProfileController::class, 'updatePreferences'])->name('profile.preferences');
    Route::post('/profile/referees', [StudentProfileController::class, 'updateReferees'])->name('profile.referees');
    Route::post('/profile/upload', [StudentProfileController::class, 'uploadDocument'])->name('profile.upload');
});


// Impersonation Routes
Route::middleware(['auth'])->group(function () {
    Route::post('/impersonate/{id}', [ImpersonateController::class, 'take'])->name('impersonate');
});

