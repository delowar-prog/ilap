<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Course;
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
        $categories = ['short', 'long', 'degree', 'diploma', 'certificate'];
        $levels = ['undergraduate', 'postgraduate', 'phd', 'professional'];
        $studyMethods = ['online', 'on_campus', 'blended'];
        $currencies = ['GBP', 'USD', 'BDT', 'SHS', 'AED', 'INR', 'EUR'];
        $intakes = ['Fall', 'Spring', 'Summer', 'Rolling', 'January', 'September'];

        return view('backend.courses.create', compact(
            'categories', 'levels', 'studyMethods', 'currencies', 'intakes'
        ));
    }

    public function store(Request $request)
    {
        $validated = $this->validateCourse($request);

        // Handle file uploads
        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')->store('courses/thumbnails', 'public');
        }
        if ($request->hasFile('brochure')) {
            $validated['brochure_path'] = $request->file('brochure')->store('courses/brochures', 'public');
        }

        // Auto-generate course code if not provided
        if (empty($validated['course_code'])) {
            $validated['course_code'] = 'CRS-' . strtoupper(uniqid());
        }

        Course::create($validated);

        return redirect()
            ->route('courses.index')
            ->with('success', 'Course created successfully!');
    }

    public function edit($id)
    {
        $course = Course::findOrFail($id);
        
        $categories = ['short', 'long', 'degree', 'diploma', 'certificate'];
        $levels = ['undergraduate', 'postgraduate', 'phd', 'professional'];
        $studyMethods = ['online', 'on_campus', 'blended'];
        $currencies = ['GBP', 'USD', 'BDT', 'SHS', 'AED', 'INR', 'EUR'];
        $intakes = ['Fall', 'Spring', 'Summer', 'Rolling', 'January', 'September'];

        return view('backend.courses.edit', compact(
            'course', 'categories', 'levels', 'studyMethods', 'currencies', 'intakes'
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

        if ($request->hasFile('brochure')) {
            if ($course->brochure_path) {
                Storage::disk('public')->delete($course->brochure_path);
            }
            $validated['brochure_path'] = $request->file('brochure')->store('courses/brochures', 'public');
        }

        $course->update($validated);

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
        if ($course->brochure_path) {
            Storage::disk('public')->delete($course->brochure_path);
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
            'study_method' => 'nullable|in:online,on_campus,blended',
            'fee' => 'required|numeric|min:0',
            'currency' => 'required|string|max:10',
            'application_fee' => 'nullable|numeric|min:0',
            'intake' => 'nullable|string|max:50',
            'application_deadline' => 'nullable|date',
            'entry_requirements' => 'nullable|string',
            'ielts_required' => 'nullable|numeric|min:0|max:9',
            'is_featured' => 'nullable|boolean',
            'is_available_for_admission' => 'nullable|boolean',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'brochure' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'status' => 'required|in:active,inactive,archived',
            'sort_order' => 'nullable|integer',
        ];

        return $request->validate($rules);
    }
}