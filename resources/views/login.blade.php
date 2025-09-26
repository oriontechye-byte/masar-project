<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول</title>
    <style>
        body { font-family: sans-serif; line-height: 1.6; padding: 20px; background-color: #f4f4f9; color: #333; }
        .container { max-width: 500px; margin: 60px auto; background-color: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h1 { text-align: center; color: #4a4a4a; margin-bottom: 20px;}
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: bold; }
        .form-group input { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box; }
        .submit-btn { display: block; width: 100%; padding: 15px; font-size: 18px; background-color: #5c67f2; color: white; border: none; border-radius: 5px; cursor: pointer; text-align: center; }
        .submit-btn:hover { background-color: #4a54d2; }
        .error-message { background-color: #fdd; color: #d93025; padding: 10px; border-radius: 5px; margin-bottom: 15px; text-align: center; }
        .register-link { text-align: center; margin-top: 20px; }
        .register-link a { color: #5c67f2; text-decoration: none; }
    </style>
</head>
<body>

    <div class="container">
        <h1>تسجيل الدخول</h1>

        @if ($errors->any())
            <div class="error-message">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="/login" method="POST">
            @csrf <div class="form-group">
                <label for="whatsapp_number">رقم الهاتف</label>
                <input type="text" id="whatsapp_number" name="whatsapp_number" required>
            </div>

            <div class="form-group">
                <label for="password">كلمة المرور</label>
                <input type="password" id="password" name="password" required>
            </div>

            <button type="submit" class="submit-btn">دخول</button>
        </form>

        <div class="register-link">
            <p>ليس لديك حساب؟ <a href="/register">سجل الآن</a></p>
        </div>
    </div>

</body>
</html>