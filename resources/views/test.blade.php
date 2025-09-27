<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>اختبار تحديد الذكاء - مشروع مسار</title>
    <style>
        body {
            font-family: 'Cairo', sans-serif;
            background-color: #f4f4f9;
            color: #333;
            line-height: 1.8;
        }
        .container {
            max-width: 800px;
            margin: 40px auto;
            padding: 40px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        h1 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 30px;
        }
        .question-block {
            margin-bottom: 25px;
            padding-bottom: 25px;
            border-bottom: 1px solid #eee;
        }
        .question-text {
            font-weight: bold;
            font-size: 18px;
            margin-bottom: 15px;
        }
        .options {
            display: flex;
            justify-content: space-around;
        }
        .options label {
            cursor: pointer;
            padding: 10px 15px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .options input[type="radio"] {
            margin-left: 8px;
        }
        .options label:hover {
            background-color: #f0f0f0;
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
            font-size: 20px;
            font-weight: bold;
            margin-top: 30px;
        }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1>أسئلة اختبار تحديد الذكاء</h1>
        <form action="/submit-test" method="POST">
            @csrf
            {{-- نرسل البيانات المخفية مع الفورم --}}
            <input type="hidden" name="student_id" value="{{ request('student_id') }}">
            <input type="hidden" name="test_type" value="{{ request('test_type') }}">

            @foreach ($questions as $question)
                <div class="question-block">
                    <p class="question-text">{{ $loop->iteration }}. {{ $question->text }}</p> {{-- <<-- تم تصحيح اسم الحقل هنا --}}
                    <div class="options">
                        <label><input type="radio" name="answers[{{ $question->id }}]" value="2" required> تنطبق بشدة</label>
                        <label><input type="radio" name="answers[{{ $question->id }}]" value="1"> تنطبق أحياناً</label>
                        <label><input type="radio" name="answers[{{ $question->id }}]" value="0"> لا تنطبق</label>
                    </div>
                </div>
            @endforeach

            <button type="submit" class="submit-btn">إرسال النتيجة</button>
        </form>
    </div>
</body>
</html>

