<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class dashboardController extends Controller
{
    /**
     * ==================================================
     * -- super admin dashboard or dashboard functionlity start here 
     * ==================================================
     */

    public function dashboard(){
        $user = auth()->user();

        // Students go to their own profile dashboard
        if ($user->hasRole('Student')) {
            return redirect()->route('student.dashboard');
        }

        return view('backend.dashboard');
    }
}
