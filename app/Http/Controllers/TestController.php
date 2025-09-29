<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class TestController extends Controller
{
    /**
     * عرض صفحة الاختبار.
     */
    public function showTest()
    {
        if (request('test_type') == 'pre' && !Session::has('student_registration_data')) {
            return redirect('/register')->withErrors(['msg' => 'الرجاء إكمال بيانات التسجيل أولاً.']);
        }
        
        $questions = DB::table('questions')->inRandomOrder()->get(); // جلب الأسئلة بترتيب عشوائي
        return view('test', ['questions' => $questions]);
    }

    /**
     * حساب وحفظ نتائج الاختبار.
     */
    public function calculateResult(Request $request)
    {
        $testType = $request->input('test_type');
        $answers = $request->input('answers');
        $studentId = $request->input('student_id');

        if ($testType === 'pre') {
            if (!session()->has('student_registration_data')) {
                return redirect('/register')->withErrors(['msg' => 'انتهت صلاحية الجلسة، الرجاء تسجيل بياناتك مرة أخرى.']);
            }
            $studentData = session('student_registration_data');
        }

        // --- **بداية التعديل والإصلاح** ---

        // جلب جميع الأسئلة مع أنواع الذكاء المرتبطة بها
        $questions = DB::table('questions')->get()->keyBy('id');
        
        // تهيئة مصفوفة الدرجات بأسماء واضحة وقيمة ابتدائية صفر
        $scores = [
            'social' => 0, 'visual' => 0, 'intrapersonal' => 0, 'kinesthetic' => 0,
            'logical' => 0, 'naturalist' => 0, 'linguistic' => 0, 'musical' => 0
        ];

        // مصفوفة لربط ID نوع الذكاء باسمه
        $typeMap = [
            1 => 'social', 2 => 'visual', 3 => 'intrapersonal', 4 => 'kinesthetic',
            5 => 'logical', 6 => 'naturalist', 7 => 'linguistic', 8 => 'musical'
        ];

        // التأكد من وجود إجابات قبل البدء بالحساب
        if ($answers) {
            foreach ($answers as $questionId => $value) {
                // التأكد من أن السؤال موجود وأن الإجابة قيمة رقمية
                if (isset($questions[$questionId]) && is_numeric($value)) {
                    $question = $questions[$questionId];
                    $typeName = $typeMap[$question->intelligence_type_id];
                    
                    // جمع قيمة الإجابة على الدرجة الحالية لنوع الذكاء
                    $scores[$typeName] += (int)$value;
                }
            }
        }
        
        // --- **نهاية التعديل والإصلاح** ---


        if ($testType === 'pre') {
            $studentId = DB::table('students')->insertGetId([
                'full_name' => $studentData['full_name'],
                'whatsapp_number' => $studentData['whatsapp_number'],
                'email' => $studentData['email'],
                'governorate' => $studentData['governorate'],
                'gpa' => $studentData['gpa'],
                'graduation_year' => $studentData['graduation_year'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('test_results')->insert([
                'student_id' => $studentId,
                'score_social' => $scores['social'],
                'score_visual' => $scores['visual'],
                'score_intrapersonal' => $scores['intrapersonal'],
                'score_kinesthetic' => $scores['kinesthetic'],
                'score_logical' => $scores['logical'],
                'score_naturalist' => $scores['naturalist'],
                'score_linguistic' => $scores['linguistic'],
                'score_musical' => $scores['musical'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
            Session::forget('student_registration_data');

        } elseif ($testType === 'post' && $studentId) {
            DB::table('test_results')->where('student_id', $studentId)->update([
                'post_score_social' => $scores['social'],
                'post_score_visual' => $scores['visual'],
                'post_score_intrapersonal' => $scores['intrapersonal'],
                'post_score_kinesthetic' => $scores['kinesthetic'],
                'post_score_logical' => $scores['logical'],
                'post_score_naturalist' => $scores['naturalist'],
                'post_score_linguistic' => $scores['linguistic'],
                'post_score_musical' => $scores['musical'],
                'updated_at' => now(),
            ]);
        }

        return redirect()->route('results.show', ['student_id' => $studentId]);
    }
}

