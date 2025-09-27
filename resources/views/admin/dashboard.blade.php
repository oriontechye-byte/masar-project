    @extends('admin.layouts.admin')

    @section('title', 'لوحة التحكم الرئيسية')

    @section('content')
        <p>أهلاً بك في لوحة التحكم الخاصة بمشروع مسار.</p>
        <div style="margin-top: 20px;">
            <h3>إحصائيات سريعة:</h3>
            <p><strong>إجمالي عدد الطلاب المسجلين:</strong> {{ $totalStudents }}</p>
            {{-- More stats will be added here --}}
        </div>
    @endsection
    
