<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{
    /**
     * عرض صفحة الاختبار
     */
    public function showTest(Request $request)
    {
        // التأكد من وجود هوية الطالب ونوع الاختبار
        if (!$request->has('student_id') || !$request->has('test_type')) {
            // يمكنك توجيهه لصفحة خطأ أو للصفحة الرئيسية
            return redirect('/')->withErrors('رابط الاختبار غير صالح.');
        }

        $questions = DB::table('questions')->get();
        return view('test', [
            'questions' => $questions,
            'student_id' => $request->student_id,
            'test_type' => $request->test_type
        ]);
    }

    /**
     * حساب النتائج وحفظها
     */
    public function calculateResult(Request $request)
    {
        $answers = $request->input('answers');
        $studentId = $request->input('student_id');
        $testType = $request->input('test_type');

        $questions = DB::table('questions')->get()->keyBy('id');
        $scores = [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0, 6 => 0, 7 => 0, 8 => 0];

        foreach ($answers as $question_id => $value) {
            if (isset($questions[$question_id])) {
                $intelligence_type_id = $questions[$question_id]->intelligence_type_id;
                $scores[$intelligence_type_id] += (int)$value;
            }
        }

        if ($testType === 'pre') {
            // هذا هو الاختبار القبلي، نقوم بإدخال سجل جديد
            DB::table('test_results')->insert([
                'student_id' => $studentId,
                'score_social' => $scores[1],
                'score_visual' => $scores[2],
                'score_intrapersonal' => $scores[3],
                'score_kinesthetic' => $scores[4],
                'score_logical' => $scores[5],
                'score_naturalist' => $scores[6],
                'score_linguistic' => $scores[7],
                'score_musical' => $scores[8],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } elseif ($testType === 'post') {
            // هذا هو الاختبار البعدي، نقوم بتحديث السجل الحالي
            DB::table('test_results')->where('student_id', $studentId)->update([
                'post_score_social' => $scores[1],
                'post_score_visual' => $scores[2],
                'post_score_intrapersonal' => $scores[3],
                'post_score_kinesthetic' => $scores[4],
                'post_score_logical' => $scores[5],
                'post_score_naturalist' => $scores[6],
                'post_score_linguistic' => $scores[7],
                'post_score_musical' => $scores[8],
                'updated_at' => now(),
            ]);
        }

        // جلب كل البيانات لعرضها في صفحة النتائج
        return $this->showResults($studentId);
    }

    /**
     * عرض صفحة النتائج النهائية
     */
    private function showResults($studentId)
    {
        $intelligenceTypes = DB::table('intelligence_types')->get()->keyBy('id');
        $result = DB::table('test_results')->where('student_id', $studentId)->first();

        // تجهيز مصفوفة النتائج القبلية
        $preScores = [
            1 => $result->score_social, 2 => $result->score_visual, 3 => $result->score_intrapersonal,
            4 => $result->score_kinesthetic, 5 => $result->score_logical, 6 => $result->score_naturalist,
            7 => $result->score_linguistic, 8 => $result->score_musical,
        ];
        arsort($preScores);

        // تجهيز مصفوفة النتائج البعدية (إذا كانت موجودة)
        $postScores = null;
        if ($result->post_score_social !== null) {
            $postScores = [
                1 => $result->post_score_social, 2 => $result->post_score_visual, 3 => $result->post_score_intrapersonal,
                4 => $result->post_score_kinesthetic, 5 => $result->post_score_logical, 6 => $result->post_score_naturalist,
                7 => $result->post_score_linguistic, 8 => $result->post_score_musical,
            ];
            arsort($postScores);
        }

        return view('results', [
            'student' => DB::table('students')->find($studentId),
            'preScores' => $preScores,
            'postScores' => $postScores,
            'intelligenceTypes' => $intelligenceTypes,
        ]);
    }
}

