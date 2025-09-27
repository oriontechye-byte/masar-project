@extends('admin.layouts.admin')

@section('title', 'تفاصيل الطالب: ' . $student->full_name)

@section('content')
    <a href="{{ route('admin.students.index') }}" style="text-decoration: none; background-color: #6c757d; color: white; padding: 8px 15px; border-radius: 4px; display: inline-block; margin-bottom: 20px;">&larr; العودة إلى قائمة الطلاب</a>

    <h3 style="margin-top: 20px; border-bottom: 2px solid #007bff; padding-bottom: 10px;">البيانات الشخصية</h3>
    <table style="width: 100%; border-collapse: collapse; text-align: right;">
        <tbody>
            <tr>
                <th style="padding: 12px; border: 1px solid #ddd; background-color: #f8f9fa; width: 200px;">الاسم الكامل</th>
                <td style="padding: 12px; border: 1px solid #ddd;">{{ $student->full_name }}</td>
            </tr>
            <tr>
                <th style="padding: 12px; border: 1px solid #ddd; background-color: #f8f9fa;">رقم الواتساب</th>
                <td style="padding: 12px; border: 1px solid #ddd;">{{ $student->whatsapp_number }}</td>
            </tr>
            <tr>
                <th style="padding: 12px; border: 1px solid #ddd; background-color: #f8f9fa;">البريد الإلكتروني</th>
                <td style="padding: 12px; border: 1px solid #ddd;">{{ $student->email ?? 'لم يتم إدخاله' }}</td>
            </tr>
            <tr>
                <th style="padding: 12px; border: 1px solid #ddd; background-color: #f8f9fa;">المحافظة</th>
                <td style="padding: 12px; border: 1px solid #ddd;">{{ $student->governorate }}</td>
            </tr>
            <tr>
                <th style="padding: 12px; border: 1px solid #ddd; background-color: #f8f9fa;">المعدل وسنة التخرج</th>
                <td style="padding: 12px; border: 1px solid #ddd;">{{ $student->gpa }}% - سنة {{ $student->graduation_year }}</td>
            </tr>
        </tbody>
    </table>

    <h3 style="margin-top: 40px; border-bottom: 2px solid #28a745; padding-bottom: 10px;">نتائج الاختبارات</h3>
    @if ($result)
        <table style="width: 100%; border-collapse: collapse; text-align: center;">
             <thead>
                <tr style="background-color: #f8f9fa;">
                    <th style="padding: 12px; border: 1px solid #ddd;">نوع الذكاء</th>
                    <th style="padding: 12px; border: 1px solid #ddd;">النتيجة القبلية</th>
                    <th style="padding: 12px; border: 1px solid #ddd;">النتيجة البعدية</th>
                </tr>
            </thead>
            <tbody>
                @php
                    // Map to link intelligence type ID to its corresponding column suffix in the database
                    $scoreMap = [
                        1 => 'social',
                        2 => 'visual',
                        3 => 'intrapersonal',
                        4 => 'kinesthetic',
                        5 => 'logical',
                        6 => 'naturalist',
                        7 => 'linguistic',
                        8 => 'musical',
                    ];
                @endphp
                @foreach ($intelligenceTypes as $id => $type)
                    @php
                        $scoreSuffix = $scoreMap[$id] ?? null;
                        $preScoreColumn = 'score_' . $scoreSuffix;
                        $postScoreColumn = 'post_score_' . $scoreSuffix;
                    @endphp
                    <tr>
                        <td style="padding: 10px; border: 1px solid #ddd; text-align: right;"><strong>{{ $type->name }}</strong></td>
                        <td style="padding: 10px; border: 1px solid #ddd; font-weight: bold;">{{ $result->$preScoreColumn ?? 'N/A' }}</td>
                        <td style="padding: 10px; border: 1px solid #ddd; font-weight: bold;">{{ $result->$postScoreColumn ?? 'لم يجرى بعد' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p style="text-align: center; padding: 20px; background-color: #fff3cd; border: 1px solid #ffeeba; border-radius: 4px;">لم يقم هذا الطالب بإجراء أي اختبار بعد.</p>
    @endif
@endsection

