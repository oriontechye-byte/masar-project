@extends('admin.layouts.admin')

@section('title', 'تفاصيل الطالب: ' . $student->full_name)

@section('content')
    <div style="margin-bottom: 20px;">
        <a href="{{ route('admin.students.index') }}" style="text-decoration: none; background-color: #6c757d; color: white; padding: 8px 15px; border-radius: 5px; font-weight: bold;">&larr; العودة إلى قائمة الطلاب</a>
    </div>

    <div class="stat-card" style="background-color: #fff; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); padding: 25px; margin-bottom: 30px;">
        <h3 style="margin-top: 0; border-bottom: 2px solid #007bff; padding-bottom: 10px; margin-bottom: 20px;">البيانات الشخصية</h3>
        <table style="width: 100%; border-collapse: collapse; text-align: right; font-size: 16px;">
            <tbody>
                <tr style="border-bottom: 1px solid #eee;">
                    <th style="padding: 12px 8px; background-color: #f8f9fa; width: 200px;">الاسم الكامل</th>
                    <td style="padding: 12px 8px;">{{ $student->full_name }}</td>
                </tr>
                <tr style="border-bottom: 1px solid #eee;">
                    <th style="padding: 12px 8px; background-color: #f8f9fa;">رقم الواتساب</th>
                    <td style="padding: 12px 8px;">{{ $student->whatsapp_number }}</td>
                </tr>
                <tr style="border-bottom: 1px solid #eee;">
                    <th style="padding: 12px 8px; background-color: #f8f9fa;">البريد الإلكتروني</th>
                    <td style="padding: 12px 8px;">{{ $student->email ?? 'لم يتم إدخاله' }}</td>
                </tr>
                <tr style="border-bottom: 1px solid #eee;">
                    <th style="padding: 12px 8px; background-color: #f8f9fa;">المحافظة</th>
                    <td style="padding: 12px 8px;">{{ $student->governorate }}</td>
                </tr>
                <tr>
                    <th style="padding: 12px 8px; background-color: #f8f9fa;">المعدل وسنة التخرج</th>
                    <td style="padding: 12px 8px;">{{ $student->gpa }}% - سنة {{ $student->graduation_year }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="stat-card" style="background-color: #fff; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); padding: 25px;">
        <h3 style="margin-top: 0; border-bottom: 2px solid #28a745; padding-bottom: 10px; margin-bottom: 20px;">نتائج الاختبارات</h3>
        @if ($result)
            <table style="width: 100%; border-collapse: collapse; text-align: center;">
                 <thead>
                    <tr style="background-color: #f8f9fa;">
                        <th style="padding: 12px; border: 1px solid #ddd; text-align: right;">نوع الذكاء</th>
                        <th style="padding: 12px; border: 1px solid #ddd;">النتيجة القبلية</th>
                        <th style="padding: 12px; border: 1px solid #ddd;">النتيجة البعدية</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $scoreMap = [
                            1 => 'social', 2 => 'visual', 3 => 'intrapersonal', 4 => 'kinesthetic',
                            5 => 'logical', 6 => 'naturalist', 7 => 'linguistic', 8 => 'musical',
                        ];
                    @endphp
                    @foreach ($intelligenceTypes as $type)
                        @php
                            $scoreSuffix = $scoreMap[$type->id] ?? null;
                            $preScoreColumn = 'score_' . $scoreSuffix;
                            $postScoreColumn = 'post_score_' . $scoreSuffix;
                        @endphp
                        <tr>
                            <td style="padding: 10px; border: 1px solid #ddd; text-align: right;"><strong>{{ $type->name }}</strong></td>
                            <td style="padding: 10px; border: 1px solid #ddd; font-weight: bold; font-size: 1.1em;">{{ $result->$preScoreColumn ?? 'N/A' }}</td>
                            <td style="padding: 10px; border: 1px solid #ddd; font-weight: bold; font-size: 1.1em;">{{ $result->$postScoreColumn ?? 'لم يجرى بعد' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p style="text-align: center; padding: 20px; background-color: #fff3cd; border: 1px solid #ffeeba; border-radius: 4px;">لم يقم هذا الطالب بإجراء أي اختبار بعد.</p>
        @endif
    </div>
@endsection
