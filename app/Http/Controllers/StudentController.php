<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class StudentController extends Controller
{
    /**
     * عرض صفحة التسجيل مع التحقق من المرحلة النشطة.
     */
    public function showRegistrationForm(Request $request)
    {
        $setting = DB::table('settings')->where('key', 'active_test_phase')->first();
        if (($setting->value ?? 'pre') !== 'pre') {
            return redirect('/')->with('error', 'فترة الاختبار القبلي مغلقة حالياً.');
        }

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
            'full_name' => ['required', 'string', 'max:255', 'regex:/^[\p{Arabic}\s]+$/u'],
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

        session(['student_registration_data' => $validatedData]);
        return Redirect::to('/test?test_type=pre');
    }

    /**
     * عرض صفحة البحث عن الاختبار البعدي مع التحقق من المرحلة النشطة.
     */
    public function showPostTestLookupForm(Request $request)
    {
        $setting = DB::table('settings')->where('key', 'active_test_phase')->first();
        if (($setting->value ?? 'pre') !== 'post') {
            return redirect('/')->with('error', 'فترة الاختبار البعدي مغلقة حالياً.');
        }
        return view('post_test_lookup');
    }

    /**
     * معالجة البحث عن الطالب لبدء الاختبار البعدي.
     */
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

        return back()->withErrors(['whatsapp_number' => 'لم يتم العثور على طالب بهذا الرقم.']);
    }

    /**
     * عرض صفحة النتائج النهائية للطالب (الكود المصحح).
     */
    public function showStudentResults($student_id)
    {
        $student = DB::table('students')->find($student_id);
        if (!$student) { abort(404, 'الطالب غير موجود'); }

        $result = DB::table('test_results')->where('student_id', $student_id)->first();
        $intelligenceTypes = DB::table('intelligence_types')->get()->keyBy('id');
        
        if (!$result) { abort(404, 'النتيجة غير موجودة'); }

        // Mapping from intelligence type ID to its corresponding column name suffix.
        $scoreMap = [
            1 => 'social', 2 => 'visual', 3 => 'intrapersonal', 4 => 'kinesthetic',
            5 => 'logical', 6 => 'naturalist', 7 => 'linguistic', 8 => 'musical'
        ];

        $preScores = [];
        $postScores = [];
        $hasPostTest = false;

        foreach ($scoreMap as $id => $nameSuffix) {
            $preColumn = 'score_' . $nameSuffix;
            $postColumn = 'post_score_' . $nameSuffix;
            
            // Populate pre-test scores
            $preScores[$id] = $result->{$preColumn} ?? 0;
            
            // Check for and populate post-test scores
            if (isset($result->{$postColumn}) && $result->{$postColumn} !== null) {
                $postScores[$id] = $result->{$postColumn};
                $hasPostTest = true;
            }
        }

        // Sort scores arrays in descending order
        arsort($preScores);
        if ($hasPostTest) {
            arsort($postScores);
        } else {
            $postScores = null; // Ensure postScores is null if no post-test was taken
        }

        return view('results', compact('student', 'preScores', 'postScores', 'intelligenceTypes', 'hasPostTest'));
    }
}

