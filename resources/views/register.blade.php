<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل بيانات الطالب - مشروع مسار</title>
    <style>
        body {
            font-family: 'Cairo', sans-serif;
            background-color: #f4f4f9;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px 0;
            margin: 0;
        }
        .container {
            max-width: 600px;
            width: 100%;
            padding: 40px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 30px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }
        input, select {
            width: 100%;
            box-sizing: border-box;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }
        .submit-btn {
            display: block;
            width: 100%;
            padding: 15px;
            cursor: pointer;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }
        .submit-btn:hover {
            background-color: #218838;
        }
        .error-summary {
            color: #721c24;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
            list-style-position: inside;
        }
        .error-summary ul {
            padding-right: 20px;
            margin: 0;
        }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1>تسجيل بيانات الطالب</h1>
        
        @if ($errors->any())
            <div class="error-summary">
                <strong>الرجاء تصحيح الأخطاء التالية:</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="/register" method="POST">
            @csrf
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
                    <option value="" disabled selected>-- اختر المحافظة --</option>
                    @foreach ($governorates as $governorate)
                        <option value="{{ $governorate }}" {{ old('governorate') == $governorate ? 'selected' : '' }}>{{ $governorate }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="gpa">المعدل في الثانوية</label>
                <input type="text" id="gpa" name="gpa" placeholder="مثال: 95.50" value="{{ old('gpa') }}" required>
            </div>
            <div class="form-group">
                <label for="graduation_year">سنة التخرج</label>
                <select id="graduation_year" name="graduation_year" required>
                     <option value="" disabled selected>-- اختر السنة --</option>
                     @foreach ($years as $year)
                        <option value="{{ $year }}" {{ old('graduation_year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                     @endforeach
                </select>
            </div>
            <button type="submit" class="submit-btn">بدء الاختبار</button>
        </form>
    </div>
</body>
</html>
