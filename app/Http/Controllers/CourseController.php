<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\DropdownOption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::when(request('search'), function ($q) {
                $search = request('search');
                $q->where(function ($sub) use ($search) {
                    $sub->where('name', 'like', "%{$search}%")
                        ->orWhere('course_code', 'like', "%{$search}%")
                        ->orWhere('partner_institute', 'like', "%{$search}%");
                });
            })
            ->when(request('course_type'), function ($q) {
                if (request('course_type') === 'ilap') {
                    $q->ilapOwn();
                } elseif (request('course_type') === 'external') {
                    $q->external();
                }
            })
            ->when(request('category'), fn($q) => $q->where('category', request('category')))
            ->when(request('status'), fn($q) => $q->where('status', request('status')))
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate(15);

        return view('backend.courses.index', compact('courses'));
    }

    public function create()
    {
        $categories   = DropdownOption::active('course_category');
        $levels       = DropdownOption::active('level_of_study');
        $subjectAreas = DropdownOption::active('subject_area');
        $studyMethods = DropdownOption::active('study_method');
        $currencies   = DropdownOption::active('currency');
        $intakes      = DropdownOption::active('intake');
        $englishTests = DropdownOption::active('english_proficiency');
        $partnerInstitutes = \App\Models\PartnerInstitute::where('is_active', true)->orderBy('name')->get();
        $ilapInstitutes = \App\Models\DropdownOption::where('category', 'department')->where('is_active', true)->orderBy('sort_order')->get();

        return view('backend.courses.create', compact(
            'categories', 'levels', 'subjectAreas', 'studyMethods', 'currencies', 'intakes', 'englishTests', 'partnerInstitutes', 'ilapInstitutes'
        ));
    }

    public function store(Request $request)
    {
        $validated = $this->validateCourse($request);

        // Auto-register new custom subject_area if not in DropdownOption system
        if (!empty($validated['subject_area'])) {
            DropdownOption::firstOrCreate(
                ['category' => 'subject_area', 'label' => $validated['subject_area']],
                ['sort_order' => 99, 'is_active' => true]
            );
        }

        // Handle file uploads
        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')->store('courses/thumbnails', 'public');
        }

        // Auto-generate course code if not provided
        if (empty($validated['course_code'])) {
            $firstChar = strtoupper(substr($validated['name'] ?? 'C', 0, 1));
            $randomNumber = mt_rand(10000, 99999);
            $validated['course_code'] = $firstChar . $randomNumber;
        }

        $course = Course::create($validated);

        // Handle modules
        if ($request->has('modules')) {
            $this->syncModules($course, $request->input('modules', []));
        }

        // Handle brochures
        if ($request->has('brochures')) {
            $this->syncBrochures($course, $request);
        }

        return redirect()
            ->route('courses.index')
            ->with('success', 'Course created successfully!');
    }

    public function edit($id)
    {
        $course = Course::findOrFail($id);
        
        $categories   = DropdownOption::active('course_category');
        $levels       = DropdownOption::active('level_of_study');
        $subjectAreas = DropdownOption::active('subject_area');
        $studyMethods = DropdownOption::active('study_method');
        $currencies   = DropdownOption::active('currency');
        $intakes      = DropdownOption::active('intake');
        $englishTests = DropdownOption::active('english_proficiency');
        $partnerInstitutes = \App\Models\PartnerInstitute::where('is_active', true)->orderBy('name')->get();
        $ilapInstitutes = \App\Models\DropdownOption::where('category', 'department')->where('is_active', true)->orderBy('sort_order')->get();

        return view('backend.courses.edit', compact(
            'course', 'categories', 'levels', 'subjectAreas', 'studyMethods', 'currencies', 'intakes', 'englishTests', 'partnerInstitutes', 'ilapInstitutes'
        ));
    }

    public function update(Request $request, $id)
    {
        $course = Course::findOrFail($id);
        $validated = $this->validateCourse($request, $course->id);

        // Handle file uploads
        if ($request->hasFile('thumbnail')) {
            if ($course->thumbnail) {
                Storage::disk('public')->delete($course->thumbnail);
            }
            $validated['thumbnail'] = $request->file('thumbnail')->store('courses/thumbnails', 'public');
        }

        $course->update($validated);

        // Handle modules
        if ($request->has('modules')) {
            $this->syncModules($course, $request->input('modules', []));
        }

        // Handle brochures
        if ($request->has('brochures')) {
            $this->syncBrochures($course, $request);
        }

        return redirect()
            ->route('courses.index')
            ->with('success', 'Course updated successfully!');
    }

    public function destroy($id)
    {
        $course = Course::findOrFail($id);

        // Check if course has applications
        if ($course->applications()->count() > 0) {
            return back()->with('error', 'Cannot delete! This course has student applications.');
        }

        // Delete files
        if ($course->thumbnail) {
            Storage::disk('public')->delete($course->thumbnail);
        }
        foreach ($course->brochures as $brochure) {
            Storage::disk('public')->delete($brochure->file_path);
        }

        $course->delete(); // soft delete

        return back()->with('success', 'Course deleted successfully!');
    }

    private function validateCourse(Request $request, $ignoreId = null)
    {
        $rules = [
            'is_ilap_course' => 'required|boolean',
            'partner_institute' => 'required_if:is_ilap_course,false|nullable|string|max:255',
            'institute_country' => 'nullable|string|max:100',
            'institute_website' => 'nullable|url|max:255',
            'course_code' => 'nullable|string|max:50|unique:courses,course_code,' . ($ignoreId ?? 'NULL'),
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:50',
            'level' => 'nullable|string|max:50',
            'subject_area' => 'nullable|string|max:100',
            'duration' => 'nullable|string|max:50',
            'duration_months' => 'nullable|integer|min:1',
            'study_method' => 'nullable|string|max:50',
            'fee' => 'required|numeric|min:0',
            'currency' => 'required|string|max:10',
            'application_fee' => 'nullable|numeric|min:0',
            'intake' => 'nullable|string|max:50',
            'application_deadline' => 'nullable|date',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'entry_requirements' => 'nullable|string',
            'english_test' => 'nullable|string|max:100',
            'english_test_score' => 'nullable|string|max:100',
            'is_featured' => 'nullable|boolean',
            'is_available_for_admission' => 'nullable|boolean',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'brochures' => 'nullable|array',
            'brochures.*.title' => 'nullable|string|max:255',
            'brochures.*.file' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'status' => 'nullable|in:active,inactive,archived',
            'sort_order' => 'nullable|integer',
        ];

        return $request->validate($rules);
    }

    private function syncModules(Course $course, array $modulesData)
    {
        $existingModuleIds = $course->modules()->pluck('id')->toArray();
        $updatedModuleIds = [];

        foreach ($modulesData as $index => $module) {
            // skip if entire row is empty
            if (empty($module['title']) && empty($module['code']) && empty($module['credit']) && empty($module['glh'])) {
                continue;
            }

            $moduleId = $module['id'] ?? null;
            $data = [
                'code' => $module['code'] ?? null,
                'title' => $module['title'],
                'credit' => $module['credit'] ?? null,
                'glh' => $module['glh'] ?? null,
                'is_mandatory' => isset($module['is_mandatory']) ? true : false,
                'priority' => $module['priority'] ?? $index,
            ];

            if ($moduleId) {
                $existing = $course->modules()->find($moduleId);
                if ($existing) {
                    $existing->update($data);
                    $updatedModuleIds[] = $existing->id;
                }
            } else {
                $newModule = $course->modules()->create($data);
                $updatedModuleIds[] = $newModule->id;
            }
        }

        $modulesToDelete = array_diff($existingModuleIds, $updatedModuleIds);
        if (!empty($modulesToDelete)) {
            $course->modules()->whereIn('id', $modulesToDelete)->delete();
        }
    }

    private function syncBrochures(Course $course, Request $request)
    {
        $existingBrochureIds = $course->brochures()->pluck('id')->toArray();
        $updatedBrochureIds = [];
        $brochuresData = $request->input('brochures', []);
        $brochuresFiles = $request->file('brochures', []);

        foreach ($brochuresData as $index => $bData) {
            $brochureId = $bData['id'] ?? null;
            $title = $bData['title'] ?? null;
            $fileObj = $brochuresFiles[$index]['file'] ?? null;

            // skip if no title and no file (and no existing ID to update)
            if (empty($title) && !$fileObj && !$brochureId) {
                continue;
            }

            if ($brochureId) {
                $existing = $course->brochures()->find($brochureId);
                if ($existing) {
                    $updateData = ['title' => $title];
                    if ($fileObj) {
                        Storage::disk('public')->delete($existing->file_path);
                        $updateData['file_path'] = $fileObj->store('courses/brochures', 'public');
                    }
                    $existing->update($updateData);
                    $updatedBrochureIds[] = $existing->id;
                }
            } else {
                if ($fileObj) {
                    $filePath = $fileObj->store('courses/brochures', 'public');
                    $newBrochure = $course->brochures()->create([
                        'title' => $title,
                        'file_path' => $filePath
                    ]);
                    $updatedBrochureIds[] = $newBrochure->id;
                }
            }
        }

        $brochuresToDelete = array_diff($existingBrochureIds, $updatedBrochureIds);
        if (!empty($brochuresToDelete)) {
            $toDelete = $course->brochures()->whereIn('id', $brochuresToDelete)->get();
            foreach ($toDelete as $b) {
                Storage::disk('public')->delete($b->file_path);
                $b->delete();
            }
        }
    }
}