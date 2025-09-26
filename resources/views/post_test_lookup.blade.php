<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>البحث عن اختبار</title>
    {{-- سنضيف تنسيقات لاحقاً لجعل الصفحة أجمل --}}
    <style>
        body { font-family: sans-serif; padding: 20px; }
        .error { color: red; font-size: 0.9em; margin-top: 5px; }
        form { margin-top: 20px; }
        label, input, button { display: block; margin-bottom: 10px; }
        input { padding: 8px; width: 250px; }
        button { padding: 10px 15px; cursor: pointer; }
    </style>
</head>
<body>

    <h1>اختبار ما بعد المحاضرة</h1>
    <p>للبدء في الاختبار، يرجى إدخال رقم الواتساب الذي قمت بالتسجيل به في اختبار ما قبل المحاضرة.</p>

    {{-- هذا الفورم سيرسل البيانات إلى الدالة handlePostTestLookup في المتحكم --}}
    <form action="/post-test" method="POST">
        @csrf

        <div>
            <label for="whatsapp_number">رقم الواتساب:</label>
            {{-- لاحظ أن name="whatsapp_number" يطابق ما يتوقعه المتحكم --}}
            <input type="text" id="whatsapp_number" name="whatsapp_number" placeholder="مثال: 771234567" value="{{ old('whatsapp_number') }}">
            
            {{-- هذا الكود مخصص لعرض أي رسالة خطأ متعلقة بهذا الحقل --}}
            @error('whatsapp_number')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <button type="submit">بدء الاختبار</button>
        </div>
    </form>

</body>
</html>

