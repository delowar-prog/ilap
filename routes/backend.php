<?php

use App\Http\Controllers\Admin\DropdownOptionController;
use App\Http\Controllers\Admin\PreAssessmentAdminController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\AgentCommissionController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\CampusController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\InstituteController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\Student\PreAssessmentController;
use App\Http\Controllers\Student\StudentProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Lab404\Impersonate\Controllers\ImpersonateController;

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [dashboardController::class, 'dashboard'])
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
    Route::get('/pre-assessment', [PreAssessmentController::class, 'index'])
        ->name('pre.assessment.index');
    Route::get('/pre-assessment/form', [PreAssessmentController::class, 'show'])
        ->name('pre.assessment.show');
    Route::post('/pre-assessment', [PreAssessmentController::class, 'store'])
        ->name('pre.assessment.store');
    Route::put('/pre-assessment', [PreAssessmentController::class, 'update'])
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
    Route::get('/pre-assessments', [PreAssessmentAdminController::class, 'index'])
        ->name('pre.assessments.index');
    Route::get('/pre-assessments/{id}', [PreAssessmentAdminController::class, 'show'])
        ->name('pre.assessments.show');
    Route::post('/pre-assessments/{id}/approve', [PreAssessmentAdminController::class, 'approve'])
        ->name('pre.assessments.approve');
    Route::post('/pre-assessments/{id}/reject', [PreAssessmentAdminController::class, 'reject'])
        ->name('pre.assessments.reject');
    Route::post('/pre-assessments/{id}/send-to-pre-enrolment', [PreAssessmentAdminController::class, 'sendToPreEnrolment'])
        ->name('pre.assessments.send_to_pre_enrolment');
    Route::post('/pre-assessments/{id}/revert-to-pending', [PreAssessmentAdminController::class, 'revertToPending'])
        ->name('pre.assessments.revert_to_pending');
    Route::delete('/pre-assessments/{id}', [PreAssessmentAdminController::class, 'destroy'])
        ->name('pre.assessments.destroy');

    Route::post('/students/{id}/approve', [StudentController::class, 'approve'])->name('students.approve');
    Route::post('/students/{id}/reject', [StudentController::class, 'reject'])->name('students.reject');
    Route::post('/students/{id}/revert-to-pending', [StudentController::class, 'revertToPending'])->name('students.revert_to_pending');
    Route::post('/students/{id}/send-to-student', [StudentController::class, 'sendToStudent'])->name('students.send_to_student');
    Route::get('/enrolled-students', [StudentController::class, 'enrolledStudents'])->name('students.enrolled');
    Route::delete('/students/{id}', [StudentController::class, 'destroy'])->name('students.destroy');
    Route::get('/students/{id}/profile-pdf', [StudentController::class, 'downloadProfilePdf'])->name('students.profile.pdf');
    Route::resource('students', StudentController::class)->only(['index', 'show']);

    // ── Configuration: Dropdown Options ───────────────────────────────────────
    Route::prefix('config/dropdown-options')->name('config.dropdown.')->group(function () {
        Route::get('/', [DropdownOptionController::class, 'index'])->name('index');
        Route::get('/{category}', [DropdownOptionController::class, 'category'])->name('category');
        Route::post('/{category}', [DropdownOptionController::class, 'store'])->name('store');
        Route::put('/option/{dropdownOption}', [DropdownOptionController::class, 'update'])->name('update');
        Route::patch('/option/{dropdownOption}/toggle', [DropdownOptionController::class, 'toggle'])->name('toggle');
        Route::delete('/option/{dropdownOption}', [DropdownOptionController::class, 'destroy'])->name('destroy');
        Route::post('/reorder', [DropdownOptionController::class, 'reorder'])->name('reorder');
    });
});

// Impersonation Routes
Route::middleware(['auth'])->group(function () {
    Route::post('/impersonate/{id}', [ImpersonateController::class, 'take'])->name('impersonate');
});
