@extends('admin.layouts.admin')

@section('title', 'لوحة التحكم الرئيسية')

@section('content')
    <p style="margin-top: 20px;">أهلاً بك في لوحة التحكم الخاصة بمشروع مسار.</p>

    <div style="margin-top: 20px;">
        <h3>إحصائيات سريعة</h3>
        <p><strong>إجمالي عدد الطلاب المسجلين:</strong> {{ $stats['students_count'] }}</p>
        {{-- سيتم إضافة المزيد من الإحصائيات هنا مستقبلاً --}}
    </div>
@endsection

