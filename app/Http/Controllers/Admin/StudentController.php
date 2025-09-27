<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    /**
     * عرض قائمة بكل الطلاب
     */
    public function index()
    {
        $students = DB::table('students')->orderBy('created_at', 'desc')->paginate(15);
        return view('admin.students.index', ['students' => $students]);
    }

    /**
     * عرض صفحة التفاصيل لطالب معين
     */
    public function show($id)
    {
        $student = DB::table('students')->find($id);
        $result = DB::table('test_results')->where('student_id', $id)->first();
        $intelligenceTypes = DB::table('intelligence_types')->get()->keyBy('id');

        // إذا لم يتم العثور على الطالب، قم بإعادته لصفحة الطلاب
        if (!$student) {
            return redirect()->route('admin.students.index')->with('error', 'الطالب غير موجود.');
        }

        return view('admin.students.show', [
            'student' => $student,
            'result' => $result,
            'intelligenceTypes' => $intelligenceTypes,
        ]);
    }
}

