<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    /**
     * Display a listing of the students.
     */
    public function index()
    {
        // Fetch all students from the database, ordering by the newest first
        $students = DB::table('students')->orderBy('created_at', 'desc')->paginate(15); // Show 15 per page

        return view('admin.students.index', ['students' => $students]);
    }

    // We will add more functions here later (like show, edit, delete)
}
