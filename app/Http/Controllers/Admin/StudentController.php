<?php

namespace App\Http\Controllers\Admin;

use App\Exports\StudentsExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class StudentController extends Controller
{
    /**
     * عرض قائمة بكل الطلاب مع الفلاتر
     */
    public function index(Request $request)
    {
        $filters = $request->only(['governorate', 'start_date', 'end_date']);
        
        $query = DB::table('students');

        if (!empty($filters['governorate'])) {
            $query->where('governorate', $filters['governorate']);
        }
        if (!empty($filters['start_date'])) {
            $query->whereDate('created_at', '>=', $filters['start_date']);
        }
        if (!empty($filters['end_date'])) {
            $query->whereDate('created_at', '<=', $filters['end_date']);
        }

        $students = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();
        
        $governorates = DB::table('students')->distinct()->pluck('governorate')->sort();

        return view('admin.students.index', [
            'students' => $students,
            'governorates' => $governorates,
            'filters' => $filters,
        ]);
    }

    /**
     * عرض صفحة التفاصيل لطالب معين
     */
    public function show($id)
    {
        $student = DB::table('students')->find($id);
        $result = DB::table('test_results')->where('student_id', $id)->first();
        $intelligenceTypes = DB::table('intelligence_types')->get()->keyBy('id');

        if (!$student) {
            return redirect()->route('admin.students.index')->with('error', 'الطالب غير موجود.');
        }

        return view('admin.students.show', [
            'student' => $student,
            'result' => $result,
            'intelligenceTypes' => $intelligenceTypes,
        ]);
    }

    /**
     * تصدير بيانات الطلاب ونتائجهم إلى ملف إكسل
     */
    public function export(Request $request) 
    {
        $filters = $request->only(['governorate', 'start_date', 'end_date']);
        $testType = $request->input('test_type', 'pre'); // Default to 'pre'
        $fileName = $testType === 'post' ? 'students_post_test_results.xlsx' : 'students_pre_test_results.xlsx';

        return Excel::download(new StudentsExport($filters, $testType), $fileName);
    }
}
