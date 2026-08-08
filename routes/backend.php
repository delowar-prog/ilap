<?php

use App\Http\Controllers\Admin\DropdownOptionController;
use App\Http\Controllers\Admin\LetterTemplateController;
use App\Http\Controllers\Admin\PreAssessmentAdminController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\StudentLetterController;
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
    Route::patch('/status-toggle/{modelType}/{id}', [\App\Http\Controllers\StatusToggleController::class, 'toggle'])->name('status.toggle');
    Route::post('/save-signature', [\App\Http\Controllers\SignatureController::class, 'saveSignature'])->name('user.signature.save');
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
    Route::post('/additional-cost/{cost}/pay', [StudentProfileController::class, 'payAdditionalCost'])->name('additional_cost.pay');
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
    Route::post('/students/{id}/terminate', [StudentController::class, 'terminateStudent'])->name('students.terminate');
    Route::post('/students/{id}/reinstall', [StudentController::class, 'reinstallStudent'])->name('students.reinstall');
    Route::get('/enrolled-students', [StudentController::class, 'enrolledStudents'])->name('students.enrolled');
    Route::delete('/students/{id}', [StudentController::class, 'destroy'])->name('students.destroy');
    Route::get('/students/{id}/profile-pdf', [StudentController::class, 'downloadProfilePdf'])->name('students.profile.pdf');
    Route::get('/students/{student}/enrolment', [StudentController::class, 'manageEnrolmentDetails'])->name('students.enrolment');
    Route::post('/students/{student}/enrolment', [StudentController::class, 'saveEnrolmentDetails'])->name('students.enrolment.save');
    Route::post('/installments/{installment}/record-payment', [StudentController::class, 'recordInstallmentPayment'])->name('installments.record_payment');
    Route::post('/installments/{installment}/approve-payment', [StudentController::class, 'approveInstallmentPayment'])->name('installments.approve_payment');
    Route::post('/installments/{installment}/reject-payment', [StudentController::class, 'rejectInstallmentPayment'])->name('installments.reject_payment');
    Route::post('/installments/{installment}/refund', [StudentController::class, 'refundInstallment'])->name('installments.refund');
    Route::post('/additional-costs/{cost}/record-payment', [StudentController::class, 'recordAdditionalCostPayment'])->name('additional_costs.record_payment');
    Route::post('/additional-costs/{cost}/approve-payment', [StudentController::class, 'approveAdditionalCostPayment'])->name('additional_costs.approve_payment');
    Route::post('/additional-costs/{cost}/reject-payment', [StudentController::class, 'rejectAdditionalCostPayment'])->name('additional_costs.reject_payment');
    Route::post('/additional-costs/{cost}/refund', [StudentController::class, 'refundAdditionalCost'])->name('additional_costs.refund');
    Route::resource('students', StudentController::class)->only(['index', 'show']);

    // ── Official Signatures & Seals CRUD ──────────────────────────────
    Route::resource('official-signatures', \App\Http\Controllers\Admin\OfficialSignatureController::class)->names('official-signatures');

    // ── Campus Types CRUD ─────────────────────────────────────────────
    Route::resource('campus-types', \App\Http\Controllers\Admin\CampusTypeController::class)->names('campus-types');

    // ── Letter Templates CRUD & Generation Routes ──────────────────────────────
    Route::get('letter-templates/{letterTemplate}/preview', [LetterTemplateController::class, 'preview'])->name('letter-templates.preview');
    Route::patch('letter-templates/{letterTemplate}/toggle', [LetterTemplateController::class, 'toggleStatus'])->name('letter-templates.toggle');
    Route::resource('letter-templates', LetterTemplateController::class)->names('letter-templates');

    Route::resource('tags', \App\Http\Controllers\TagController::class)->except(['create', 'show', 'edit']);

    Route::get('students/{student}/letter-preview-modal', [StudentLetterController::class, 'previewModal'])->name('students.letters.preview_modal');
    Route::post('students/{student}/generate-letter', [StudentLetterController::class, 'generate'])->name('students.letters.generate');
    Route::get('generated-letters/{generatedLetter}/download', [StudentLetterController::class, 'downloadHistory'])->name('students.letters.download');
    Route::get('generated-letters/{generatedLetter}/preview', [StudentLetterController::class, 'previewLetter'])->name('students.letters.preview');
    Route::patch('generated-letters/{generatedLetter}/send', [StudentLetterController::class, 'sendToStudent'])->name('students.letters.send');
    Route::delete('generated-letters/{generatedLetter}', [StudentLetterController::class, 'deleteHistory'])->name('students.letters.delete');
    Route::get('letter-history', [StudentLetterController::class, 'globalHistory'])->name('letters.history');

    // ── Invoice Templates CRUD & Generation Routes ──────────────────────────────
    Route::get('invoice-templates/{invoiceTemplate}/preview', [\App\Http\Controllers\Admin\InvoiceTemplateController::class, 'preview'])->name('invoice-templates.preview');
    Route::patch('invoice-templates/{invoiceTemplate}/toggle', [\App\Http\Controllers\Admin\InvoiceTemplateController::class, 'toggleStatus'])->name('invoice-templates.toggle');
    Route::resource('invoice-templates', \App\Http\Controllers\Admin\InvoiceTemplateController::class)->names('invoice-templates');

    Route::get('students/{student}/invoice-preview-modal', [\App\Http\Controllers\Admin\StudentInvoiceController::class, 'previewModal'])->name('students.invoices.preview_modal');
    Route::post('students/{student}/generate-invoice', [\App\Http\Controllers\Admin\StudentInvoiceController::class, 'generate'])->name('students.invoices.generate');
    Route::get('generated-invoices/{generatedInvoice}/download', [\App\Http\Controllers\Admin\StudentInvoiceController::class, 'downloadHistory'])->name('students.invoices.download');
    Route::get('generated-invoices/{generatedInvoice}/preview', [\App\Http\Controllers\Admin\StudentInvoiceController::class, 'previewInvoice'])->name('students.invoices.preview');
    Route::patch('generated-invoices/{generatedInvoice}/send', [\App\Http\Controllers\Admin\StudentInvoiceController::class, 'sendToStudent'])->name('students.invoices.send');
    Route::delete('generated-invoices/{generatedInvoice}', [\App\Http\Controllers\Admin\StudentInvoiceController::class, 'deleteHistory'])->name('students.invoices.delete');
    Route::get('invoice-history', [\App\Http\Controllers\Admin\StudentInvoiceController::class, 'globalHistory'])->name('invoices.history');

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

    // ── Configuration: Partner Institutes ───────────────────────────────────────
    Route::prefix('config/partner-institutes')->name('config.partner_institutes.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\PartnerInstituteController::class, 'index'])->name('index');
        Route::post('/', [\App\Http\Controllers\Admin\PartnerInstituteController::class, 'store'])->name('store');
        Route::put('/{partnerInstitute}', [\App\Http\Controllers\Admin\PartnerInstituteController::class, 'update'])->name('update');
        Route::patch('/{partnerInstitute}/toggle', [\App\Http\Controllers\Admin\PartnerInstituteController::class, 'toggle'])->name('toggle');
        Route::delete('/{partnerInstitute}', [\App\Http\Controllers\Admin\PartnerInstituteController::class, 'destroy'])->name('destroy');
    });
});

// Impersonation Routes
Route::middleware(['auth'])->group(function () {
    Route::post('/impersonate/{id}', [ImpersonateController::class, 'take'])->name('impersonate');
});
