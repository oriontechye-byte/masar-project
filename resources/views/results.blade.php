<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>نتيجتك النهائية - مشروع مسار</title>
    <style>
        body {
            font-family: 'Cairo', sans-serif;
            background-color: #f7f9fc;
            color: #333;
            line-height: 1.7;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 900px;
            margin: 20px auto;
            padding: 40px;
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.08);
        }
        .header {
            text-align: center;
            border-bottom: 1px solid #eee;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        h1 {
            color: #2c3e50;
            margin: 0;
        }
        h2 {
            font-weight: normal;
            color: #007bff;
            margin-top: 10px;
        }
        h3 {
            color: #34495e;
            margin-top: 40px;
            margin-bottom: 20px;
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
        }
        .results-section, .recommendations-section {
            margin-bottom: 40px;
        }
        .result-list { list-style: none; padding: 0; }
        .result-item {
            padding: 15px;
            margin-bottom: 12px;
            border-radius: 8px;
            background-color: #f9f9f9;
            border: 1px solid #e1e1e1;
        }
        .result-item.top-score { background-color: #e9f7ec; border-color: #c3e6cb; }
        .score-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px; }
        .score-name { font-weight: bold; }
        .score-value { background-color: #007bff; color: white; padding: 3px 12px; border-radius: 20px; font-size: 14px; }
        .result-item.top-score .score-value { background-color: #28a745; }
        .progress-bar-container { background-color: #e9ecef; border-radius: 20px; height: 10px; overflow: hidden; }
        .progress-bar { background-color: #007bff; height: 100%; border-radius: 20px; transition: width 0.5s ease-in-out; }
        .result-item.top-score .progress-bar { background-color: #28a745; }

        .recommendation-card {
            background: #fff;
            border: 1px solid #e1e1e1;
            border-radius: 8px;
            padding: 25px;
            margin-bottom: 20px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        }
        .recommendation-card h4 {
            font-size: 20px;
            color: #0056b3;
            margin-top: 0;
        }
        .recommendation-card p { margin-top: 0; color: #555; }
        .recommendation-card .careers { font-weight: bold; color: #333; }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>تقرير تحليل الذكاءات المتعددة</h1>
            <h2>مرحباً بك، {{ $student->full_name ?? 'طالبنا العزيز' }}</h2>
        </div>

        @if ($postScores)
            {{-- This section will be displayed only after the post-test --}}
            <div class="results-section">
                <h3>نتائجك في الاختبار البعدي</h3>
                <ul class="result-list">
                    @php $counter = 0; @endphp
                    @foreach ($postScores as $typeId => $data)
                        <li class="result-item {{ $counter < 3 ? 'top-score' : '' }}">
                            <div class="score-header">
                                <span class="score-name">{{ $intelligenceTypes[$typeId]->name }}</span>
                                <span class="score-value">{{ round($data['percentage']) }}%</span>
                            </div>
                            <div class="progress-bar-container">
                                <div class="progress-bar" style="width: {{ max(0, min(100, (float) ($data['percentage'] ?? 0)) ) }}%;"></div>
                            </div>
                        </li>
                        @php $counter++; @endphp
                    @endforeach
                </ul>
            </div>

            <div class="recommendations-section">
                <h3>التخصصات المقترحة لك</h3>
                <p>بناءً على نتائجك، هذه هي أبرز نقاط قوتك والتخصصات التي نوصي بها:</p>
                @php $topPostScores = array_slice($postScores, 0, 3, true); @endphp
                @foreach ($topPostScores as $typeId => $score)
                    <div class="recommendation-card">
                        <h4>{{ $intelligenceTypes[$typeId]->name }}</h4>
                        <p>{{ $intelligenceTypes[$typeId]->description }}</p>
                        <p class="careers">التخصصات والمهن المقترحة: {{ $intelligenceTypes[$typeId]->careers }}</p>
                    </div>
                @endforeach
            </div>
        @elseif (!empty($preScores))
            {{-- This section will be displayed only after the pre-test --}}
            <div class="results-section">
                <h3>نتائجك في الاختبار القبلي</h3>
                <p>هذه هي نقاط قوتك الأولية. استخدم هذه المعلومات للتركيز على تطوير مهاراتك خلال المحاضرة.</p>
                <ul class="result-list">
                    @php $counter = 0; @endphp
                    @foreach ($preScores as $typeId => $data)
                        <li class="result-item {{ $counter < 3 ? 'top-score' : '' }}">
                             <div class="score-header">
                                <span class="score-name">
                                    {{ $intelligenceTypes[$typeId]->name }}
                                    @if($counter < 1) <span class="trophy">🏆</span> @endif
                                </span>
                                <span class="score-value">{{ round($data['percentage']) }}%</span>
                            </div>
                            <div class="progress-bar-container">
                                <div class="progress-bar" style="width: {{ max(0, min(100, (float) ($data['percentage'] ?? 0)) ) }}%;"></div>
                            </div>
                        </li>
                        @php $counter++; @endphp
                    @endforeach
                </ul>
            </div>
             <div class="recommendations-section">
                <h3>أبرز نقاط قوتك الحالية</h3>
                 @php $topPreScores = array_slice($preScores, 0, 3, true); @endphp
                @foreach ($topPreScores as $typeId => $score)
                    <div class="recommendation-card">
                        <h4>{{ $intelligenceTypes[$typeId]->name }}</h4>
                        <p>{{ $intelligenceTypes[$typeId]->description }}</p>
                        <p class="careers">يمكنك التفوق في مجالات مثل: {{ $intelligenceTypes[$typeId]->careers }}</p>
                    </div>
                @endforeach
            </div>
        @else
            <p>لم يتم العثور على نتائج لهذا الطالب.</p>
        @endif
    </div>
</body>
</html>

