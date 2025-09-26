<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // تم إضافة هذا السطر لأنه مطلوب للوظائف الجديدة
use Illuminate\Support\Facades\Redirect;

class StudentController extends Controller
{
    public function showRegistrationForm()
    {
        $governorates = ['أمانة العاصمة', 'عدن', 'عمران', 'أبين', 'الضالع', 'البيضاء', 'الحديدة', 'الجوف', 'المهرة', 'المحويت', 'ذمار', 'حضرموت', 'حجة', 'إب', 'لحج', 'مأرب', 'ريمة', 'صعدة', 'صنعاء', 'شبوة', 'سقطرى', 'تعز'];
        sort($governorates);
        $years = range(date('Y'), date('Y') - 4);

        return view('register', [
            'governorates' => $governorates,
            'years' => $years
        ]);
    }

    public function register(Request $request)
    {
        // 1. Validate the incoming data (without password)
        $validatedData = $request->validate([
            'full_name' => ['required', 'string', 'max:255', 'regex:/^[\p{Arabic}\s]{1,}\s[\p{Arabic}\s]{1,}\s[\p{Arabic}\s]{1,}\s[\p{Arabic}\s]{1,}$/u'],
            'whatsapp_number' => 'required|string|regex:/^[7][01378]\d{7}$/', // We remove 'unique' for now
            'email' => 'nullable|email|max:255',
            'governorate' => 'required|string|max:255',
            'gpa' => 'required|numeric|min:0|max:100',
            'graduation_year' => 'required|digits:4',
        ], [
            'full_name.regex' => 'يجب إدخال الاسم الرباعي.',
            'whatsapp_number.regex' => 'يجب إدخال رقم هاتف يمني صحيح مكون من 9 أرقام (مثال: 771234567).',
        ]);

        // 2. Store the validated data in the session instead of the database
        session(['student_data' => $validatedData]);

        // 3. Redirect the user to the test page for the pre-lecture test
        return Redirect::to('/test?test_type=pre');
    }

    /**
     * عرض صفحة البحث عن الطالب لاختبار ما بعد المحاضرة
     */
    public function showPostTestLookupForm()
    {
        return view('post_test_lookup'); // سنقوم بإنشاء هذه الصفحة في الخطوة التالية
    }

    /**
     * معالجة البحث عن الطالب
     */
    public function handlePostTestLookup(Request $request)
    {
        $request->validate([
            'whatsapp_number' => 'required|string|regex:/^[7][01378]\d{7}$/',
        ], [
            'whatsapp_number.required' => 'يرجى إدخال رقم الهاتف.',
            'whatsapp_number.regex' => 'الرقم الذي أدخلته غير صحيح.',
        ]);

        // البحث عن الطالب باستخدام رقم هاتفه
        $student = DB::table('students')->where('whatsapp_number', $request->whatsapp_number)->first();

        if ($student) {
            // إذا تم العثور على الطالب، قم بتحويله إلى صفحة الاختبار
            return Redirect::to('/test?student_id=' . $student->id . '&test_type=post');
        }

        // إذا لم يتم العثور عليه، ارجع إلى نفس الصفحة مع رسالة خطأ
        return back()->withErrors([
            'whatsapp_number' => 'لم يتم العثور على طالب بهذا الرقم. يرجى التأكد من أنك سجلت في اختبار قبل المحاضرة.',
        ]);
    }
}
