@extends('admin.layouts.admin')

@section('title', 'تعديل السؤال')

@section('content')
    <h3>تعديل السؤال رقم: {{ $question->id }}</h3>

    <form action="{{ route('admin.questions.update', $question->id) }}" method="POST" style="margin-top: 20px; background: #fff; padding: 25px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
        @csrf
        @method('PUT')
        <div style="margin-bottom: 15px;">
            <label for="text" style="display: block; font-weight: bold; margin-bottom: 5px;">نص السؤال:</label>
            <textarea id="text" name="text" rows="4" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;" required>{{ old('text', $question->text) }}</textarea>
            @error('text') <div style="color: red; font-size: 0.9em; margin-top: 5px;">{{ $message }}</div> @enderror
        </div>

        <div style="margin-bottom: 20px;">
            <label for="intelligence_type_id" style="display: block; font-weight: bold; margin-bottom: 5px;">نوع الذكاء:</label>
            <select id="intelligence_type_id" name="intelligence_type_id" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;" required>
                @foreach($intelligenceTypes as $id => $name)
                    <option value="{{ $id }}" {{ old('intelligence_type_id', $question->intelligence_type_id) == $id ? 'selected' : '' }}>{{ $name }}</option>
                @endforeach
            </select>
            @error('intelligence_type_id') <div style="color: red; font-size: 0.9em; margin-top: 5px;">{{ $message }}</div> @enderror
        </div>

        <div>
            <button type="submit" style="background-color: #007bff; color: white; padding: 12px 22px; border: none; border-radius: 5px; cursor: pointer; font-weight: bold; font-size: 16px;">تحديث السؤال</button>
            <a href="{{ route('admin.questions.index') }}" style="text-decoration: none; color: #6c757d; margin-right: 15px;">إلغاء</a>
        </div>
    </form>
@endsection
