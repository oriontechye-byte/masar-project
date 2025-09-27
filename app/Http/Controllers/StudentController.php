<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class StudentController extends Controller
{
    /**
     * عرض صفحة التسجيل.
     */
    public function showRegistrationForm()
    {
        $governorates = ['أمانة العاصمة', 'عدن', 'عمران', 'أبين', 'الضالع', 'البيضاء', 'الحديدة', 'الجوف', 'المهرة', 'المحويت', 'ذمار', 'حضرموت', 'حجة', 'إب', 'لحج', 'مأرب', 'ريمة', 'صعدة', 'صنعاء', 'شبوة', 'سقطرى', 'تعز'];
        sort($governorates);
        $years = range(date('Y'), date('Y') - 5);

        return view('register', [
            'governorates' => $governorates,
            'years' => $years
        ]);
    }

    /**
     * التحقق من بيانات الطالب وتخزينها مؤقتاً في الجلسة.
     */
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'full_name' => ['required', 'string', 'max:255', 'regex:/^[\p{Arabic}\s]+$/u'], // قاعدة تحقق أبسط
            'whatsapp_number' => 'required|string|unique:students,whatsapp_number|regex:/^[7][01378]\d{7}$/',
            'email' => 'nullable|email|max:255',
            'governorate' => 'required|string|max:255',
            'gpa' => 'required|numeric|min:0|max:100',
            'graduation_year' => 'required|digits:4',
        ], [
            'full_name.regex' => 'الرجاء إدخال الاسم باللغة العربية.',
            'whatsapp_number.unique' => 'رقم الهاتف هذا مسجل بالفعل في النظام.',
            'whatsapp_number.regex' => 'يجب إدخال رقم هاتف يمني صحيح مكون من 9 أرقام (مثال: 771234567).',
        ]);

        // تخزين البيانات المؤقت في الجلسة
        session(['student_registration_data' => $validatedData]);

        // توجيه الطالب إلى صفحة الاختبار القبلي
        return Redirect::to('/test?test_type=pre');
    }
    
    // --- بقية الدوال تبقى كما هي ---

    public function showPostTestLookupForm()
    {
        return view('post_test_lookup');
    }

    public function handlePostTestLookup(Request $request)
    {
        $request->validate([
            'whatsapp_number' => 'required|string|regex:/^[7][01378]\d{7}$/',
        ], [
            'whatsapp_number.required' => 'يرجى إدخال رقم الهاتف.',
            'whatsapp_number.regex' => 'الرقم الذي أدخلته غير صحيح.',
        ]);

        $student = DB::table('students')->where('whatsapp_number', $request->whatsapp_number)->first();

        if ($student) {
            return Redirect::to('/test?student_id=' . $student->id . '&test_type=post');
        }

        return back()->withErrors([
            'whatsapp_number' => 'لم يتم العثور على طالب بهذا الرقم.',
        ]);
    }

    public function showStudentResults($student_id)
    {
        $student = DB::table('students')->find($student_id);
        if (!$student) { abort(404, 'الطالب غير موجود'); }
        $result = DB::table('test_results')->where('student_id', $student_id)->first();
        $intelligenceTypes = DB::table('intelligence_types')->get()->keyBy('id');
        $preScores = [];
        $postScores = null;
        if ($result) {
            foreach ($intelligenceTypes as $id => $type) {
                $score_key = 'score_' . \Illuminate\Support\Str::of($type->name)->snake()->explode('_')->last();
                $preScores[$id] = $result->{$score_key} ?? 0;
            }
            arsort($preScores);
            
            $post_score_key_check = 'post_score_social';
            if (isset($result->{$post_score_key_check})) {
                $postScores = [];
                foreach ($intelligenceTypes as $id => $type) {
                     $post_score_key = 'post_score_' . \Illuminate\Support\Str::of($type->name)->snake()->explode('_')->last();
                     $postScores[$id] = $result->{$post_score_key} ?? 0;
                }
                arsort($postScores);
            }
        }
        return view('results', compact('student', 'preScores', 'postScores', 'intelligenceTypes'));
    }
}

