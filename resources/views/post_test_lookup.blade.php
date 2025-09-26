<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>البحث عن اختبار</title>
    <style>
        body {
            font-family: 'Cairo', sans-serif; /* خط عربي جميل */
            background-color: #f4f4f9;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            max-width: 500px;
            width: 100%;
            padding: 40px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        h1 {
            color: #2c3e50;
            margin-bottom: 15px;
        }
        p {
            color: #555;
            margin-bottom: 30px;
        }
        .error-summary {
            color: #721c24;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
            text-align: right;
            list-style-position: inside;
        }
        form {
            margin-top: 20px;
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            text-align: right;
        }
        input[type="text"] {
            width: 100%;
            box-sizing: border-box;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
            text-align: right;
        }
        button {
            display: block;
            width: 100%;
            padding: 12px 15px;
            cursor: pointer;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 18px;
            font-weight: bold;
            margin-top: 20px;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>

    <div class="container">
        <h1>اختبار ما بعد المحاضرة</h1>
        <p>للبدء في الاختبار، يرجى إدخال رقم الواتساب الذي قمت بالتسجيل به في اختبار ما قبل المحاضرة.</p>
        
        {{-- صندوق أنيق لعرض الأخطاء --}}
        @if ($errors->any())
            <div class="error-summary">
                <strong>خطأ:</strong>
                <ul style="padding-right: 20px; margin-top: 10px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="/post-test" method="POST">
            @csrf
            <div>
                <label for="whatsapp_number">رقم الواتساب:</label>
                <input type="text" id="whatsapp_number" name="whatsapp_number" placeholder="مثال: 771234567" value="{{ old('whatsapp_number') }}" required>
            </div>
            <div>
                <button type="submit">بدء الاختبار</button>
            </div>
        </form>
    </div>

</body>
</html>

