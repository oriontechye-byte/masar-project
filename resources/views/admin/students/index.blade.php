@extends('admin.layouts.admin')

@section('title', 'إدارة الطلاب')

@section('content')
    <div class="filters-card" style="background-color: #fff; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); padding: 25px; margin-bottom: 30px;">
        <h3 style="margin-top: 0; border-bottom: 1px solid #eee; padding-bottom: 15px; margin-bottom: 20px;">فلترة وتصدير البيانات</h3>
        <form id="filters-form" action="{{ route('admin.students.index') }}" method="GET">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; align-items: flex-end;">
                <div>
                    <label for="governorate" style="font-weight: bold; margin-bottom: 5px; display: block;">المحافظة:</label>
                    <select id="governorate" name="governorate" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                        <option value="">كل المحافظات</option>
                        @foreach($governorates as $gov)
                            <option value="{{ $gov }}" {{ ($filters['governorate'] ?? '') == $gov ? 'selected' : '' }}>{{ $gov }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="start_date" style="font-weight: bold; margin-bottom: 5px; display: block;">من تاريخ:</label>
                    <input type="date" id="start_date" name="start_date" value="{{ $filters['start_date'] ?? '' }}" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                </div>
                <div>
                    <label for="end_date" style="font-weight: bold; margin-bottom: 5px; display: block;">إلى تاريخ:</label>
                    <input type="date" id="end_date" name="end_date" value="{{ $filters['end_date'] ?? '' }}" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                </div>
                <div style="display: flex; gap: 10px;">
                    <button type="submit" style="flex: 1; background-color: #007bff; color: white; padding: 10px 18px; border-radius: 5px; font-weight: bold; border: none; cursor: pointer;">بحث</button>
                    <a href="{{ route('admin.students.index') }}" style="flex: 1; text-align:center; background-color: #6c757d; color: white; padding: 10px 18px; border-radius: 5px; font-weight: bold; text-decoration: none;">إلغاء</a>
                </div>
            </div>
        </form>
        <div style="margin-top: 20px; padding-top: 20px; border-top: 1px solid #eee; display: flex; flex-wrap: wrap; gap: 15px;">
            <a id="exportPreTest" href="#" class="export-btn" style="background-color: #28a745; color: white; padding: 10px 20px; border-radius: 5px; text-decoration: none; font-weight: bold;">تصدير نتائج الاختبار القبلي (Excel)</a>
            <a id="exportPostTest" href="#" class="export-btn" style="background-color: #17a2b8; color: white; padding: 10px 20px; border-radius: 5px; text-decoration: none; font-weight: bold;">تصدير نتائج الاختبار البعدي (Excel)</a>
        </div>
    </div>

    @if(session('error'))
        <div style="background-color: #f8d7da; color: #721c24; padding: 10px; border: 1px solid #f5c6cb; border-radius: 5px; margin-bottom: 20px;">
            {{ session('error') }}
        </div>
    @endif

    <table style="width: 100%; border-collapse: collapse; margin-top: 20px; background: #fff; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
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
                    <td style="padding: 10px; border: 1px solid #ddd;">{{ $loop->iteration + ($students->currentPage() - 1) * $students->perPage() }}</td>
                    <td style="padding: 10px; border: 1px solid #ddd;">{{ $student->full_name }}</td>
                    <td style="padding: 10px; border: 1px solid #ddd;">{{ $student->whatsapp_number }}</td>
                    <td style="padding: 10px; border: 1px solid #ddd;">{{ \Carbon\Carbon::parse($student->created_at)->format('Y-m-d') }}</td>
                    <td style="padding: 10px; border: 1px solid #ddd; text-align: center;">
                        <a href="{{ route('admin.students.show', $student->id) }}" style="text-decoration: none; background-color: #007bff; color: white; padding: 5px 12px; border-radius: 4px;">عرض التفاصيل</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="padding: 15px; text-align: center;">لا يوجد طلاب لعرضهم بناءً على الفلاتر المحددة.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    
    <div style="margin-top: 20px;">
        {{ $students->links() }}
    </div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const exportPreBtn = document.getElementById('exportPreTest');
    const exportPostBtn = document.getElementById('exportPostTest');
    
    const governorate = document.getElementById('governorate').value;
    const startDate = document.getElementById('start_date').value;
    const endDate = document.getElementById('end_date').value;
    
    const baseUrl = "{{ route('admin.students.export') }}";

    const preParams = new URLSearchParams({
        governorate: governorate,
        start_date: startDate,
        end_date: endDate,
        test_type: 'pre'
    });
    exportPreBtn.href = `${baseUrl}?${preParams.toString()}`;

    const postParams = new URLSearchParams({
        governorate: governorate,
        start_date: startDate,
        end_date: endDate,
        test_type: 'post'
    });
    exportPostBtn.href = `${baseUrl}?${postParams.toString()}`;
});
</script>
@endsection
