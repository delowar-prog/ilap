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

// ==================== Pre-Assessment Routes (Student) ====================
Route::middleware(['auth', 'role:Student'])->group(function () {
    Route::get('/pre-assessment', [\App\Http\Controllers\Student\PreAssessmentController::class, 'index'])
        ->name('pre.assessment.index');
    Route::get('/pre-assessment/form', [\App\Http\Controllers\Student\PreAssessmentController::class, 'show'])
        ->name('pre.assessment.show');
    Route::post('/pre-assessment', [\App\Http\Controllers\Student\PreAssessmentController::class, 'store'])
        ->name('pre.assessment.store');
    Route::put('/pre-assessment', [\App\Http\Controllers\Student\PreAssessmentController::class, 'update'])
        ->name('pre.assessment.update');
});

// ==================== Student Profile Routes ====================
Route::middleware(['auth', 'role:Student', 'pre.assessment'])->prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard', [StudentProfileController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [StudentProfileController::class, 'profile'])->name('profile');
    Route::get('/profile/edit', [StudentProfileController::class, 'editProfile'])->name('profile.edit');
    Route::post('/profile/personal', [StudentProfileController::class, 'updatePersonal'])->name('profile.personal');
    Route::post('/profile/academic', [StudentProfileController::class, 'updateAcademic'])->name('profile.academic');
    Route::post('/profile/english', [StudentProfileController::class, 'updateEnglish'])->name('profile.english');
    Route::post('/profile/preferences', [StudentProfileController::class, 'updatePreferences'])->name('profile.preferences');
    Route::post('/profile/referees', [StudentProfileController::class, 'updateReferees'])->name('profile.referees');
    Route::post('/profile/upload', [StudentProfileController::class, 'uploadDocument'])->name('profile.upload');
});

// ==================== Pre-Assessment Admin Routes ====================
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/pre-assessments', [\App\Http\Controllers\Admin\PreAssessmentAdminController::class, 'index'])
        ->name('pre.assessments.index');
    Route::get('/pre-assessments/{id}', [\App\Http\Controllers\Admin\PreAssessmentAdminController::class, 'show'])
        ->name('pre.assessments.show');
    Route::post('/pre-assessments/{id}/approve', [\App\Http\Controllers\Admin\PreAssessmentAdminController::class, 'approve'])
        ->name('pre.assessments.approve');
    Route::post('/pre-assessments/{id}/reject', [\App\Http\Controllers\Admin\PreAssessmentAdminController::class, 'reject'])
        ->name('pre.assessments.reject');
        
    Route::resource('students', \App\Http\Controllers\Admin\StudentController::class)->only(['index', 'show']);
});


// Impersonation Routes
Route::middleware(['auth'])->group(function () {
    Route::post('/impersonate/{id}', [ImpersonateController::class, 'take'])->name('impersonate');
});

