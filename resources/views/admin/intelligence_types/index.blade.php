@extends('admin.layouts.admin')

@section('title', 'إدارة أنواع الذكاء')

@section('content')
    <h3>أنواع الذكاء والشروحات</h3>
    <p>من هنا يمكنك تعديل الوصف والتخصصات المقترحة لكل نوع من أنواع الذكاء التي تظهر في صفحة النتائج النهائية للطالب.</p>

    @if (session('success'))
        <div style="background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
            {{ session('success') }}
        </div>
    @endif

    <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
        <thead>
            <tr style="background-color: #f2f2f2; text-align: right;">
                <th style="padding: 12px; border: 1px solid #ddd;">الاسم</th>
                <th style="padding: 12px; border: 1px solid #ddd;">الوصف</th>
                <th style="padding: 12px; border: 1px solid #ddd; width: 150px; text-align: center;">إجراءات</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($types as $type)
                <tr>
                    <td style="padding: 10px; border: 1px solid #ddd; font-weight: bold;">{{ $type->name }}</td>
                    <td style="padding: 10px; border: 1px solid #ddd;">{{ \Illuminate\Support\Str::limit($type->description, 100) }}</td>
                    <td style="padding: 10px; border: 1px solid #ddd; text-align: center;">
                        <a href="{{ route('admin.types.edit', $type->id) }}" style="text-decoration: none; background-color: #ffc107; color: black; padding: 5px 12px; border-radius: 4px; font-size: 14px;">تعديل</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
