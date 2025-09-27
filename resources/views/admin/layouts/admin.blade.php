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
        .sidebar h2 { text-align: center; margin-bottom: 30px; color: #fff; }
        .sidebar-nav a { color: #ecf0f1; text-decoration: none; display: block; padding: 12px 15px; border-radius: 4px; margin-bottom: 8px; transition: background-color 0.3s; }
        .sidebar-nav a.active, .sidebar-nav a:hover { background-color: #34495e; }
        .main-content { flex-grow: 1; padding: 30px; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; border-bottom: 1px solid #ddd; padding-bottom: 15px;}
        .logout-form { margin-top: auto; }
        .logout-btn { background: #e74c3c; color: white; padding: 10px 15px; border: none; border-radius: 4px; cursor: pointer; width: 100%; font-size: 16px; }
        .content-card { background: #fff; padding: 25px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="admin-layout">
        <aside class="sidebar">
            <h2>مشروع مسار</h2>
            <nav class="sidebar-nav">
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">لوحة التحكم</a>
                <a href="{{ route('admin.students.index') }}" class="{{ request()->routeIs('admin.students.index') ? 'active' : '' }}">إدارة الطلاب</a>
            </nav>
            <form class="logout-form" action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout-btn">تسجيل الخروج</button>
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

