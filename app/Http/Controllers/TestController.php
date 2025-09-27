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
        // نتأكد من وجود بيانات الطالب في الجلسة إذا كان الاختبار قبلياً
        if (request('test_type') == 'pre' && !Session::has('student_registration_data')) {
            // إذا لم تكن هناك بيانات، نعيده لصفحة التسجيل
            return redirect('/register')->withErrors(['msg' => 'الرجاء إكمال بيانات التسجيل أولاً.']);
        }
        
        $questions = DB::table('questions')->get();
        return view('test', ['questions' => $questions]);
    }

    /**
     * حساب وحفظ نتائج الاختبار.
     */
    public function calculateResult(Request $request)
    {
        $testType = $request->input('test_type');
        $answers = $request->input('answers');

        // حساب الدرجات
        $questions = DB::table('questions')->get()->keyBy('id');
        $scores = [];
        $typeMap = [
            1 => 'social', 2 => 'visual', 3 => 'intrapersonal', 4 => 'kinesthetic',
            5 => 'logical', 6 => 'naturalist', 7 => 'linguistic', 8 => 'musical'
        ];
        
        // تهيئة مصفوفة الدرجات
        foreach ($typeMap as $name) {
            $scores[$name] = 0;
        }

        if ($answers) {
            foreach ($answers as $question_id => $value) {
                if (isset($questions[$question_id])) {
                    $question = $questions[$question_id];
                    $typeName = $typeMap[$question->intelligence_type_id];
                    $scores[$typeName] += (int)$value;
                }
            }
        }

        $studentId = $request->input('student_id');

        if ($testType === 'pre') {
            // إذا كان الاختبار قبلياً، نقوم بعملية الحفظ المتكاملة
            $studentData = session('student_registration_data');

            // 1. إنشاء سجل الطالب
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

            // 2. إنشاء سجل النتائج
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
            
            // 3. مسح البيانات المؤقتة من الجلسة
            Session::forget('student_registration_data');

        } elseif ($testType === 'post') {
            // إذا كان الاختبار بعدياً، نقوم فقط بتحديث السجل الحالي
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

        // في كلتا الحالتين، نوجه الطالب لصفحة النتائج الخاصة به
        return redirect()->route('results.show', ['student_id' => $studentId]);
    }
}
