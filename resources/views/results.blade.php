<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>نتيجتك النهائية</title>
    <style>
        body {
            font-family: 'Cairo', sans-serif;
            background-color: #f4f4f9;
            color: #333;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: 40px auto;
            padding: 40px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }
        h1, h2 {
            text-align: center;
            color: #2c3e50;
        }
        h1 {
            margin-bottom: 10px;
        }
        h2 {
            font-weight: normal;
            color: #555;
            margin-bottom: 30px;
        }
        .result-list {
            list-style: none;
            padding: 0;
        }
        .result-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 15px 20px;
            margin-bottom: 10px;
            border-radius: 8px;
            transition: all 0.3s ease;
            border: 1px solid #e1e1e1;
        }
        .result-item:nth-child(odd) {
            background-color: #f9f9f9;
        }
        .result-item.top-score {
            background-color: #d4edda; /* Light green for top score */
            border-color: #c3e6cb;
            transform: scale(1.02);
            box-shadow: 0 4px 8px rgba(0,0,0,0.05);
        }
        .score-name {
            font-weight: bold;
            font-size: 1.1em;
        }
        .score-value {
            background-color: #007bff;
            color: white;
            padding: 6px 15px;
            border-radius: 20px;
            font-weight: bold;
            min-width: 50px;
            text-align: center;
        }
        .result-item.top-score .score-value {
            background-color: #28a745; /* Darker green for top score value */
        }
        .trophy {
            margin-left: 15px;
            color: #ffc107;
            font-size: 1.2em;
        }
    </style>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1>نتائج اختبار تحديد الذكاءات المتعددة</h1>
        <h2>أبرز أنواع الذكاء لديك هي:</h2>

        <ul class="result-list">
            {{-- الكود الخاص بك لعرض النتائج يعمل هنا بدون تغيير --}}
            @php $isFirst = true; @endphp
            @foreach ($scores as $typeId => $score)
                <li class="result-item {{ $isFirst ? 'top-score' : '' }}">
                    <span class="score-name">
                        {{ $intelligenceTypes[$typeId]->name }}
                        @if($isFirst)
                            <span class="trophy">🏆</span> {{-- إضافة أيقونة كأس للفائز --}}
                        @endif
                    </span>
                    <span class="score-value">{{ $score }}</span>
                </li>
                @php $isFirst = false; @endphp
            @endforeach
        </ul>
    </div>
</body>
</html>

