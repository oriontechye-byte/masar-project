@extends('admin.layouts.admin')

@section('title', 'إدارة أسئلة الاختبار')

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h3>قائمة أسئلة الاختبار</h3>
        <a href="{{ route('admin.questions.create') }}" style="text-decoration: none; background-color: #28a745; color: white; padding: 10px 18px; border-radius: 5px; font-weight: bold;">+ إضافة سؤال جديد</a>
    </div>

    @if (session('success'))
        <div style="background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
            {{ session('success') }}
        </div>
    @endif

    <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
        <thead>
            <tr style="background-color: #f2f2f2; text-align: right;">
                <th style="padding: 12px; border: 1px solid #ddd; width: 50px;">#</th>
                <th style="padding: 12px; border: 1px solid #ddd;">نص السؤال</th>
                <th style="padding: 12px; border: 1px solid #ddd; width: 200px;">نوع الذكاء</th>
                <th style="padding: 12px; border: 1px solid #ddd; width: 180px; text-align: center;">إجراءات</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($questions as $question)
                <tr>
                    <td style="padding: 10px; border: 1px solid #ddd;">{{ $question->id }}</td>
                    <td style="padding: 10px; border: 1px solid #ddd;">{{ $question->text }}</td>
                    <td style="padding: 10px; border: 1px solid #ddd;">{{ $question->type_name }}</td>
                    <td style="padding: 10px; border: 1px solid #ddd; text-align: center;">
                        <a href="{{ route('admin.questions.edit', $question->id) }}" style="text-decoration: none; background-color: #ffc107; color: black; padding: 5px 12px; border-radius: 4px; font-size: 14px;">تعديل</a>
                        <form action="{{ route('admin.questions.destroy', $question->id) }}" method="POST" style="display: inline-block; margin-right: 5px;" onsubmit="return confirm('هل أنت متأكد من رغبتك في حذف هذا السؤال؟');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="background-color: #dc3545; color: white; padding: 5px 12px; border-radius: 4px; font-size: 14px; border: none; cursor: pointer;">حذف</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="padding: 15px; text-align: center;">لا توجد أسئلة حالياً.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    
    <div style="margin-top: 20px;">
        {{ $questions->links() }}
    </div>
@endsection
