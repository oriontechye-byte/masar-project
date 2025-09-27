@extends('admin.layouts.admin')

@section('title', 'تفاصيل الطالب: ' . $student->full_name)

@section('content')
    <a href="{{ route('admin.students.index') }}" style="text-decoration: none; background-color: #6c757d; color: white; padding: 8px 15px; border-radius: 4px; display: inline-block; margin-bottom: 20px;">&rarr; العودة إلى قائمة الطلاب</a>

    <h3 style="margin-top: 20px;">البيانات الشخصية</h3>
    <table style="width: 100%; border-collapse: collapse; text-align: right;">
        <tr>
            <th style="padding: 10px; border: 1px solid #ddd; background-color: #f2f2f2; width: 200px;">الاسم الكامل</th>
            <td style="padding: 10px; border: 1px solid #ddd;">{{ $student->full_name }}</td>
        </tr>
        <tr>
            <th style="padding: 10px; border: 1px solid #ddd; background-color: #f2f2f2;">رقم الواتساب</th>
            <td style="padding: 10px; border: 1px solid #ddd;">{{ $student->whatsapp_number }}</td>
        </tr>
        <tr>
            <th style="padding: 10px; border: 1px solid #ddd; background-color: #f2f2f2;">البريد الإلكتروني</th>
            <td style="padding: 10px; border: 1px solid #ddd;">{{ $student->email ?? 'لم يتم إدخاله' }}</td>
        </tr>
        <tr>
            <th style="padding: 10px; border: 1px solid #ddd; background-color: #f2f2f2;">المحافظة</th>
            <td style="padding: 10px; border: 1px solid #ddd;">{{ $student->governorate }}</td>
        </tr>
        <tr>
            <th style="padding: 10px; border: 1px solid #ddd; background-color: #f2f2f2;">المعدل وسنة التخرج</th>
            <td style="padding: 10px; border: 1px solid #ddd;">{{ $student->gpa }}% - سنة {{ $student->graduation_year }}</td>
        </tr>
    </table>

    <h3 style="margin-top: 30px;">نتائج الاختبارات</h3>
    @if ($result)
        <table style="width: 100%; border-collapse: collapse; text-align: center;">
             <thead>
                <tr style="background-color: #f2f2f2;">
                    <th style="padding: 12px; border: 1px solid #ddd;">نوع الذكاء</th>
                    <th style="padding: 12px; border: 1px solid #ddd;">النتيجة القبلية</th>
                    <th style="padding: 12px; border: 1px solid #ddd;">النتيجة البعدية</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($intelligenceTypes as $type)
                    <tr>
                        <td style="padding: 10px; border: 1px solid #ddd; text-align: right;"><strong>{{ $type->name }}</strong></td>
                        <td style="padding: 10px; border: 1px solid #ddd;">{{ $result->{'score_'.strtolower(explode(' ', $type->name)[1])} ?? 'N/A' }}</td>
                        <td style="padding: 10px; border: 1px solid #ddd;">{{ $result->{'post_score_'.strtolower(explode(' ', $type->name)[1])} ?? 'لم يجرى بعد' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p style="text-align: center; padding: 20px; background-color: #fff3cd; border: 1px solid #ffeeba; border-radius: 4px;">لم يقم هذا الطالب بإجراء أي اختبار بعد.</p>
    @endif
@endsection
