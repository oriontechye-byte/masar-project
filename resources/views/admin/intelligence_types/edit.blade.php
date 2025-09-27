@extends('admin.layouts.admin')

@section('title', 'تعديل: ' . $type->name)

@section('content')
    <h3>تعديل: {{ $type->name }}</h3>

    <form action="{{ route('admin.types.update', $type->id) }}" method="POST" style="margin-top: 20px; background: #fff; padding: 25px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
        @csrf
        @method('PUT')
        <div style="margin-bottom: 15px;">
            <label for="description" style="display: block; font-weight: bold; margin-bottom: 5px;">الوصف (يظهر في صفحة النتائج):</label>
            <textarea id="description" name="description" rows="5" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;" required>{{ old('description', $type->description) }}</textarea>
            @error('description') <div style="color: red; font-size: 0.9em; margin-top: 5px;">{{ $message }}</div> @enderror
        </div>

        <div style="margin-bottom: 20px;">
            <label for="careers" style="display: block; font-weight: bold; margin-bottom: 5px;">التخصصات والمهن المقترحة:</label>
            <textarea id="careers" name="careers" rows="3" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;" required>{{ old('careers', $type->careers) }}</textarea>
            @error('careers') <div style="color: red; font-size: 0.9em; margin-top: 5px;">{{ $message }}</div> @enderror
        </div>

        <div>
            <button type="submit" style="background-color: #007bff; color: white; padding: 12px 22px; border: none; border-radius: 5px; cursor: pointer; font-weight: bold; font-size: 16px;">حفظ التعديلات</button>
            <a href="{{ route('admin.types.index') }}" style="text-decoration: none; color: #6c757d; margin-right: 15px;">إلغاء</a>
        </div>
    </form>
@endsection
