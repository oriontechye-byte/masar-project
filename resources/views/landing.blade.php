<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>مشروع مسار - اكتشف تخصصك الجامعي</title>
    <style>
        @keyframes fadeIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes slideIn { from { opacity: 0; transform: translateX(-30px); } to { opacity: 1; transform: translateX(0); } }
        body { font-family: 'Cairo', sans-serif; background-color: #f8f9fa; color: #343d46; line-height: 1.7; margin: 0; }
        .container { max-width: 1100px; margin: 0 auto; padding: 0 15px; }
        .navbar { background: #fff; padding: 15px 0; box-shadow: 0 2px 4px rgba(0,0,0,0.05); animation: fadeIn 0.8s ease-out; }
        .navbar .container { display: flex; justify-content: space-between; align-items: center; }
        .logo { font-size: 24px; font-weight: 700; color: #0056b3; }
        .hero { background: linear-gradient(135deg, #0056b3 0%, #007bff 100%); color: white; padding: 100px 0; text-align: center; }
        .hero-content { animation: fadeIn 1s ease-out 0.5s; animation-fill-mode: backwards; }
        .hero h1 { font-size: 48px; margin-bottom: 20px; }
        .hero p { font-size: 20px; margin-bottom: 30px; opacity: 0.9; }
        .cta-button { background-color: #ffc107; color: #333; padding: 15px 35px; text-decoration: none; border-radius: 50px; font-weight: 700; font-size: 18px; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        .cta-button:hover { transform: translateY(-3px); box-shadow: 0 6px 20px rgba(0,0,0,0.15); }
        .features { padding: 80px 0; }
        .section-title { text-align: center; font-size: 36px; color: #343d46; margin-bottom: 60px; }
        .features-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 40px; }
        .feature-card { background: #fff; padding: 30px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.08); text-align: center; animation: fadeIn 1s ease-out; transition: transform 0.3s ease; }
        .feature-card:hover { transform: translateY(-5px); }
        .feature-icon { font-size: 48px; color: #007bff; margin-bottom: 20px; }
        .feature-card h3 { font-size: 22px; margin-bottom: 15px; }
        .footer { background: #343d46; color: #adb5bd; padding: 40px 0; text-align: center; }
        .alert-message { padding: 15px; background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; border-radius: 5px; margin-bottom: 20px; text-align: center; }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <div class="logo">مسار</div>
        </div>
    </nav>

    <header class="hero">
        <div class="container hero-content">
             @if (session('message'))
                <div class="alert-message" style="background-color: #fff3cd; color: #856404; border-color: #ffeeba; max-width: 600px; margin: 0 auto 20px auto;">
                    {{ session('message') }}
                </div>
            @endif
        
            <h1>اكتشف مسارك الأكاديمي والمهني</h1>
            <p>مشروع مسار ليس مجرد اختبار، بل هو رحلة فريدة لقياس تطورك ومساعدتك على فهم قدراتك الحقيقية لاختيار التخصص الأنسب لك.</p>

            @if ($activePhase == 'pre')
                <a href="{{ route('register') }}" class="cta-button">ابدأ الاختبار القبلي</a>
            @else
                <a href="{{ route('post-test') }}" class="cta-button">ابدأ الاختبار البعدي</a>
            @endif
        </div>
    </header>

    <section class="features">
        <div class="container">
            <h2 class="section-title">لماذا مشروع مسار؟</h2>
            <div class="features-grid">
                <div class="feature-card" style="animation-delay: 0.2s;">
                    <div class="feature-icon">💡</div>
                    <h3>فكرة فريدة</h3>
                    <p>نقيس قدراتك مرتين، مرة قبل المحاضرة ومرة بعدها، لنعطيك تقريراً دقيقاً عن مدى تطورك وفهمك لنقاط قوتك.</p>
                </div>
                <div class="feature-card" style="animation-delay: 0.4s;">
                    <div class="feature-icon">📊</div>
                    <h3>تحليل شخصي</h3>
                    <p>تحصل على تقرير مفصل يوضح لك أنواع الذكاء التي تتمتع بها، مع توصيات مخصصة للتخصصات الجامعية التي تناسبك.</p>
                </div>
                <div class="feature-card" style="animation-delay: 0.6s;">
                    <div class="feature-icon">🧭</div>
                    <h3>توجيه موثوق</h3>
                    <p>نعتمد على نظرية الذكاءات المتعددة المعترف بها عالمياً لمساعدتك على اتخاذ قرار واثق بشأن مستقبلك.</p>
                </div>
            </div>
        </div>
    </section>

    <footer class="footer">
        <div class="container">
            <p>&copy; 2025 مشروع مسار. جميع الحقوق محفوظة.</p>
        </div>
    </footer>
</body>
</html>
