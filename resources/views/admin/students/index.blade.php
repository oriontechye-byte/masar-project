@extends('admin.layouts.admin')

@section('title', 'إدارة الطلاب')

@section('content')
    <p>هنا يمكنك عرض وإدارة جميع الطلاب المسجلين في النظام.</p>

    @if(session('error'))
        <div style="background-color: #f8d7da; color: #721c24; padding: 10px; border: 1px solid #f5c6cb; border-radius: 5px; margin-bottom: 20px;">
            {{ session('error') }}
        </div>
    @endif

    <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
        <thead>
            <tr style="background-color: #f2f2f2; text-align: right;">
                <th style="padding: 12px; border: 1px solid #ddd;">#</th>
                <th style="padding: 12px; border: 1px solid #ddd;">الاسم الكامل</th>
                <th style="padding: 12px; border: 1px solid #ddd;">رقم الواتساب</th>
                <th style="padding: 12px; border: 1px solid #ddd;">تاريخ التسجيل</th>
                <th style="padding: 12px; border: 1px solid #ddd; text-align: center;">إجراءات</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($students as $student)
                <tr>
                    <td style="padding: 10px; border: 1px solid #ddd;">{{ $loop->iteration }}</td>
                    <td style="padding: 10px; border: 1px solid #ddd;">{{ $student->full_name }}</td>
                    <td style="padding: 10px; border: 1px solid #ddd;">{{ $student->whatsapp_number }}</td>
                    <td style="padding: 10px; border: 1px solid #ddd;">{{ \Carbon\Carbon::parse($student->created_at)->format('Y-m-d') }}</td>
                    <td style="padding: 10px; border: 1px solid #ddd; text-align: center;">
                        <a href="{{ route('admin.students.show', $student->id) }}" style="text-decoration: none; background-color: #007bff; color: white; padding: 5px 12px; border-radius: 4px;">عرض التفاصيل</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="padding: 15px; text-align: center;">لا يوجد طلاب مسجلون حالياً.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    
    <div style="margin-top: 20px;">
        {{ $students->links() }}
    </div>
@endsection

