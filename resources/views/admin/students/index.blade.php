@extends('admin.layouts.admin')

@section('title', 'إدارة الطلاب')

@section('content')
    <p>هنا يمكنك عرض وإدارة جميع الطلاب المسجلين في النظام.</p>

    <div style="overflow-x: auto; margin-top: 20px;">
        <table style="width: 100%; border-collapse: collapse; text-align: right;">
            <thead>
                <tr style="background-color: #f2f2f2;">
                    <th style="padding: 12px; border: 1px solid #ddd;">#</th>
                    <th style="padding: 12px; border: 1px solid #ddd;">الاسم الكامل</th>
                    <th style="padding: 12px; border: 1px solid #ddd;">رقم الواتساب</th>
                    <th style="padding: 12px; border: 1px solid #ddd;">المحافظة</th>
                    <th style="padding: 12px; border: 1px solid #ddd;">تاريخ التسجيل</th>
                    <th style="padding: 12px; border: 1px solid #ddd;">عرض النتائج</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($students as $student)
                    <tr>
                        <td style="padding: 12px; border: 1px solid #ddd;">{{ $student->id }}</td>
                        <td style="padding: 12px; border: 1px solid #ddd;">{{ $student->full_name }}</td>
                        <td style="padding: 12px; border: 1px solid #ddd;">{{ $student->whatsapp_number }}</td>
                        <td style="padding: 12px; border: 1px solid #ddd;">{{ $student->governorate }}</td>
                        <td style="padding: 12px; border: 1px solid #ddd;">{{ \Carbon\Carbon::parse($student->created_at)->format('Y-m-d') }}</td>
                        <td style="padding: 12px; border: 1px solid #ddd;">
                            <a href="{{ route('results.show', $student->id) }}" target="_blank" style="text-decoration: none; background-color: #007bff; color: white; padding: 5px 10px; border-radius: 4px;">عرض</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="padding: 12px; border: 1px solid #ddd; text-align: center;">لا يوجد طلاب مسجلون حالياً.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 20px;">
        {{ $students->links() }}
    </div>
@endsection
