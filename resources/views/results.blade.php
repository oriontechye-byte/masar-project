<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>نتيجتك النهائية</title>
    <style>
        body { font-family: sans-serif; line-height: 1.6; padding: 20px; background-color: #f4f4f9; color: #333; }
        .container { max-width: 800px; margin: 0 auto; background-color: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 2px B10px rgba(0,0,0,0.1); }
        h1, h2 { text-align: center; color: #4a4a4a; }
        .result-list { list-style: none; padding: 0; }
        .result-item { display: flex; justify-content: space-between; padding: 15px; margin-bottom: 10px; border-radius: 5px; }
        .result-item:nth-child(odd) { background-color: #f9f9f9; }
        .result-item.top-score { background-color: #e8eaf6; border: 2px solid #5c67f2; }
        .score-name { font-weight: bold; }
        .score-value { background-color: #5c67f2; color: white; padding: 5px 10px; border-radius: 15px; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <h1>نتائج اختبار تحديد الذكاءات المتعددة</h1>
        <h2>أبرز أنواع الذكاء لديك هي:</h2>

        <ul class="result-list">
            @php $isFirst = true; @endphp
            @foreach ($scores as $typeId => $score)
                <li class="result-item {{ $isFirst ? 'top-score' : '' }}">
                    <span class="score-name">{{ $intelligenceTypes[$typeId]->name }}</span>
                    <span class="score-value">{{ $score }}</span>
                </li>
                @php $isFirst = false; @endphp
            @endforeach
        </ul>
    </div>
</body>
</html>