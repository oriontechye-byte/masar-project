<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>اختبار تحديد الذكاء</title>
    {{-- Styles from previous step --}}
</head>
<body>
    <div class="container">
        <h1>أسئلة اختبار تحديد الذكاء</h1>
        <form action="/submit-test" method="POST">
            @csrf
            <input type="hidden" name="student_id" value="{{ request('student_id') }}">

            @foreach ($questions as $question)
                <div class="question-block">
                    <p class="question-text">{{ $loop->iteration }}. {{ $question->text }}</p>
                    <div class="options">
                        <label><input type="radio" name="answers[{{ $question->id }}]" value="3" required> تنطبق بشدة</label>
                        <label><input type="radio" name="answers[{{ $question->id }}]" value="2"> تنطبق أحيانًا</label>
                        <label><input type="radio" name="answers[{{ $question->id }}]" value="1"> لا تنطبق</label>
                    </div>
                </div>
            @endforeach
            <button type="submit" class="submit-btn">عرض النتيجة</button>
        </form>
    </div>
</body>
</html>