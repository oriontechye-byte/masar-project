@extends('admin.layouts.admin')

@section('title', 'إعدادات الاختبار')

@section('styles')
<style>
    .settings-card {
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        padding: 25px;
    }
    .form-group {
        margin-bottom: 20px;
    }
    .form-group label {
        display: block;
        font-weight: bold;
        margin-bottom: 15px;
        font-size: 1.1em;
    }
    .radio-group label {
        font-weight: normal;
        margin-right: 25px;
        font-size: 1em;
    }
    .btn-submit {
        background-color: #007bff;
        color: white;
        padding: 10px 25px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-weight: bold;
        font-size: 16px;
    }
    .alert-success {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
        padding: 15px;
        border-radius: 5px;
        margin-bottom: 20px;
    }
</style>
@endsection

@section('content')
    <div class="settings-card">
        <h3>التحكم في مرحلة الاختبار النشطة</h3>
        <p>اختر المرحلة التي تريد تفعيلها للطلاب. سيظهر لهم زر الدخول للمرحلة النشطة فقط في الصفحة الرئيسية.</p>
        
        @if (session('success'))
            <div class="alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('admin.settings.update') }}" method="POST" style="margin-top: 20px;">
            @csrf
            @method('POST')
            <div class="form-group">
                <label>المرحلة النشطة حالياً:</label>
                <div class="radio-group">
                    <label>
                        <input type="radio" name="active_phase" value="pre" {{ $activePhase == 'pre' ? 'checked' : '' }}>
                        الاختبار القبلي (صفحة التسجيل)
                    </label>
                    <label>
                        <input type="radio" name="active_phase" value="post" {{ $activePhase == 'post' ? 'checked' : '' }}>
                        الاختبار البعدي (صفحة البحث برقم الهاتف)
                    </label>
                </div>
            </div>

            <button type="submit" class="btn-submit">حفظ الإعدادات</button>
        </form>
    </div>
@endsection
