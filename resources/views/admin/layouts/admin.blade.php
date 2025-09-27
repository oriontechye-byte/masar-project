    <!DOCTYPE html>
    <html lang="ar" dir="rtl">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>@yield('title', 'لوحة التحكم') - مشروع مسار</title>
        <style>
            body { font-family: 'Cairo', sans-serif; margin: 0; background-color: #f4f7f6; }
            .admin-layout { display: flex; min-height: 100vh; }
            .sidebar { width: 250px; background-color: #2c3e50; color: #ecf0f1; padding: 20px; display: flex; flex-direction: column; }
            .sidebar h2 { text-align: center; margin-bottom: 30px; }
            .sidebar a { color: #ecf0f1; text-decoration: none; display: block; padding: 10px 15px; border-radius: 4px; margin-bottom: 5px; }
            .sidebar a.active, .sidebar a:hover { background-color: #34495e; }
            .main-content { flex-grow: 1; padding: 30px; }
            .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
            .logout-btn { background: #e74c3c; color: white; padding: 8px 15px; border: none; border-radius: 4px; cursor: pointer; }
            .content-card { background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        </style>
        <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet">
    </head>
    <body>
        <div class="admin-layout">
            <aside class="sidebar">
                <h2>مشروع مسار</h2>
                <nav>
                    <a href="{{ route('admin.dashboard') }}" class="active">لوحة التحكم</a>
                    {{-- Links to other admin pages will be added here --}}
                </nav>
                <form action="{{ route('logout') }}" method="POST" style="margin-top: auto;">
                    @csrf
                    <button type="submit" class="logout-btn" style="width:100%;">تسجيل الخروج</button>
                </form>
            </aside>
            <main class="main-content">
                <header class="header">
                    <h1>@yield('title')</h1>
                    <div>
                        <strong>{{ Auth::user()->name }}</strong>
                    </div>
                </header>
                <div class="content-card">
                    @yield('content')
                </div>
            </main>
        </div>
    </body>
    </html>
    
