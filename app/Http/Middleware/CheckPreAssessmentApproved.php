<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckPreAssessmentApproved
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        // Only apply to students
        if (!$user || !$user->hasRole('Student')) {
            return $next($request);
        }

        $student = $user->student;
        if (!$student) return $next($request);

        $assessment = $student->preAssessment;

        // Not submitted yet → redirect to form
        if (!$assessment || $assessment->assessment_status === 'not_submitted') {
            return redirect()->route('pre.assessment.show');
        }

        // Pending or Rejected → show status page (but only if NOT already on status/form routes)
        if (in_array($assessment->assessment_status, ['pending', 'rejected'])) {
            if (!$request->routeIs('pre.assessment.*')) {
                return redirect()->route('pre.assessment.index');
            }
        }

        return $next($request);
    }
}
