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
        .results-section, .comparison-section, .recommendations-section {
            margin-bottom: 40px;
        }
        .result-list { list-style: none; padding: 0; }
        .result-item {
            display: flex;
            align-items: center;
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 8px;
            background-color: #f9f9f9;
            border: 1px solid #e1e1e1;
        }
        .result-item.top-score { background-color: #e9f7ec; border-color: #c3e6cb; }
        .score-name { font-weight: bold; flex-grow: 1; }
        .score-value { background-color: #007bff; color: white; padding: 5px 15px; border-radius: 20px; font-weight: bold; }
        .result-item.top-score .score-value { background-color: #28a745; }
        .trophy { margin-left: 10px; color: #ffc107; }
        
        .recommendation-card {
            background: #fff;
            border: 1px solid #e1e1e1;
            border-radius: 8px;
            padding: 25px;
            margin-bottom: 20px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        }
        .recommendation-card p { margin-top: 0; color: #555; }
        .recommendation-card .careers { font-weight: bold; color: #333; }
        
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 12px 15px; text-align: center; border: 1px solid #ddd; }
        th { background-color: #f2f2f2; font-weight: bold; color: #333; }
        .comparison-value { font-size: 1.2em; font-weight: bold; }
        .increase { color: #28a745; }
        .decrease { color: #dc3545; }
    </style>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>تقرير تحليل الذكاءات المتعددة</h1>
            <h2>مرحباً بك، {{ $student->full_name ?? 'طالبنا العزيز' }}</h2>
        </div>

        @if ($postScores)
            <div class="recommendations-section">
                <h3>التخصصات المقترحة لك</h3>
                <p>بناءً على نتائجك في الاختبار البعدي، هذه هي أبرز نقاط قوتك والتخصصات التي نوصي بها:</p>
                @php $topPostScores = array_slice($postScores, 0, 3, true); @endphp
                @foreach ($topPostScores as $typeId => $score)
                    <div class="recommendation-card">
                        <h4>{{ $intelligenceTypes[$typeId]->name }}</h4>
                        <p>{{ $intelligenceTypes[$typeId]->description }}</p>
                        <p class="careers">التخصصات والمهن المقترحة: {{ $intelligenceTypes[$typeId]->careers }}</p>
                    </div>
                @endforeach
            </div>

            <div class="comparison-section">
                <h3>مقارنة بين نتائجك</h3>
                <p>هذا الجدول يوضح تطور أعلى 3 ذكاءات لديك بين الاختبار القبلي والبعدي.</p>
                <table>
                    <thead>
                        <tr>
                            <th>نوع الذكاء</th>
                            <th>النتيجة القبلية</th>
                            <th>النتيجة البعدية</th>
                            <th>التطور</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($postScores as $typeId => $postScore)
                            @php
                                $preScore = $preScores[$typeId] ?? 0;
                                $change = $postScore - $preScore;
                                $changeClass = $change > 0 ? 'increase' : ($change < 0 ? 'decrease' : '');
                                $changeSign = $change > 0 ? '+' : '';
                            @endphp
                            <tr>
                                <td><strong>{{ $intelligenceTypes[$typeId]->name }}</strong></td>
                                <td class="comparison-value">{{ $preScore }}</td>
                                <td class="comparison-value">{{ $postScore }}</td>
                                <td class="comparison-value {{ $changeClass }}">{{ $changeSign }}{{ $change }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        
        @else
            <div class="results-section">
                <h3>نتائجك في الاختبار القبلي</h3>
                <p>هذه هي نقاط قوتك الأولية. استخدم هذه المعلومات للتركيز على تطوير مهاراتك خلال المحاضرة.</p>
                <ul class="result-list">
                    @php $isFirst = true; @endphp
                    @foreach ($preScores as $typeId => $score)
                        <li class="result-item {{ $isFirst ? 'top-score' : '' }}">
                            <span class="score-name">
                                {{ $intelligenceTypes[$typeId]->name }}
                                @if($isFirst) <span class="trophy">🏆</span> @endif
                            </span>
                            <span class="score-value">{{ $score }}</span>
                        </li>
                        @php $isFirst = false; @endphp
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
</body>
</html>
