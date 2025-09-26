<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>أسئلة اختبار تحديد الذكاء</title>
    <style>
        body {
            font-family: 'Cairo', sans-serif;
            background-color: #f4f4f9;
            color: #333;
            line-height: 1.6;
        }
        .container {
            max-width: 800px;
            margin: 40px auto;
            padding: 30px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #2c3e50;
            text-align: center;
            margin-bottom: 20px;
        }
        .question-list {
            list-style: none;
            padding: 0;
        }
        .question-item {
            background: #f9f9f9;
            border-right: 5px solid #3498db;
            padding: 20px;
            margin-bottom: 15px;
            border-radius: 5px 0 0 5px;
        }
        .question-text {
            font-weight: bold;
            font-size: 1.1em;
            margin-bottom: 15px;
        }
        .options {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
        }
        .option {
            display: flex;
            align-items: center;
            margin: 5px 10px;
            cursor: pointer;
        }
        .option input[type="radio"] {
            margin-left: 10px;
        }
        .submit-btn {
            display: block;
            width: 100%;
            padding: 15px;
            font-size: 18px;
            font-weight: bold;
            color: #fff;
            background-color: #28a745;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 30px;
            transition: background-color 0.3s ease;
        }
        .submit-btn:hover {
            background-color: #218838;
        }
    </style>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>

    <div class="container">
        <h1>أسئلة اختبار تحديد الذكاء</h1>

        {{-- لاحظ أن action يذهب إلى المسار الصحيح /submit-test --}}
        <form action="/submit-test" method="POST">
            @csrf
            
            {{-- حقل مخفي لإرسال هوية الطالب مع الإجابات، وهو ضروري جداً --}}
            <input type="hidden" name="student_id" value="{{ request('student_id') }}">

            <ul class="question-list">
                {{-- الكود الخاص بك لعرض الأسئلة من قاعدة البيانات يعمل بشكل ممتاز هنا --}}
                @foreach ($questions as $index => $question)
                    <li class="question-item">
                        {{-- تم تغيير $question->text إلى $question->question_text ليطابق اسم العمود في قاعدة البيانات --}}
                        <p class="question-text">{{ ($index + 1) . '. ' . $question->question_text }}</p>
                        <div class="options">
                            <label class="option">
                                {{-- تم تغيير القيم إلى أرقام لتسهيل عملية الحساب في المتحكم --}}
                                <input type="radio" name="answers[{{ $question->id }}]" value="2" required>
                                تنطبق بشدة
                            </label>
                            <label class="option">
                                <input type="radio" name="answers[{{ $question->id }}]" value="1">
                                تنطبق أحياناً
                            </label>
                            <label class="option">
                                <input type="radio" name="answers[{{ $question->id }}]" value="0">
                                لا تنطبق
                            </label>
                        </div>
                    </li>
                @endforeach
            </ul>

            <button type="submit" class="submit-btn">عرض النتيجة</button>
        </form>
    </div>

</body>
</html>

