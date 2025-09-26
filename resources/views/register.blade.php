<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تسجيل بيانات الطالب</title>
    {{-- Add the <style> block here from a previous step --}}
</head>
<body>
    <div class="container">
        <h1>تسجيل بيانات الطالب</h1>
        @if ($errors->any())
            {{-- Add the error display div here --}}
        @endif

        <form action="/register" method="POST">
            @csrf
            {{-- Remove the password and password_confirmation fields --}}
            <div class="form-group">
                <label for="full_name">الاسم الرباعي</label>
                <input type="text" id="full_name" name="full_name" value="{{ old('full_name') }}" required>
            </div>
            <div class="form-group">
                <label for="whatsapp_number">رقم الهاتف (9 أرقام يبدأ بـ 7)</label>
                <input type="text" id="whatsapp_number" name="whatsapp_number" value="{{ old('whatsapp_number') }}" placeholder="مثال: 771234567" required>
            </div>
            <div class="form-group">
                <label for="email">البريد الإلكتروني (اختياري)</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}">
            </div>
            <div class="form-group">
                <label for="governorate">المحافظة</label>
                <select id="governorate" name="governorate" required>
                     {{-- Add the governorates options here --}}
                </select>
            </div>
            <div class="form-group">
                <label for="gpa">المعدل في الثانوية</label>
                <input type="text" id="gpa" name="gpa" placeholder="مثال: 95.50" value="{{ old('gpa') }}" required>
            </div>
            <div class="form-group">
                <label for="graduation_year">سنة التخرج</label>
                <select id="graduation_year" name="graduation_year" required>
                    {{-- Add the years options here --}}
                </select>
            </div>
            <button type="submit" class="submit-btn">بدء الاختبار</button>
        </form>
    </div>
</body>
</html>