<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student; // Using the Student Model

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard with statistics.
     */
    public function index()
    {
        $stats = [
            'students_count' => Student::count(),
            // More stats can be added here in the future
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
