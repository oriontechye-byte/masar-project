<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\StudentController as AdminStudentController; // إعادة تسمية لتجنب التعارض

/*
|--------------------------------------------------------------------------
| المسارات الخاصة بواجهة الطالب
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return redirect('/register');
});

// مسارات تسجيل الطالب والاختبارات
Route::get('/register', [StudentController::class, 'showRegistrationForm']);
Route::post('/register', [StudentController::class, 'register']);
Route::get('/post-test', [StudentController::class, 'showPostTestLookupForm']);
Route::post('/post-test', [StudentController::class, 'handlePostTestLookup']);

// مسارات عملية الاختبار والنتائج
Route::get('/test', [TestController::class, 'showTest']);
Route::post('/submit-test', [TestController::class, 'calculateResult']);
Route::get('/results/{student_id}', [StudentController::class, 'showStudentResults'])->name('results.show');

/*
|--------------------------------------------------------------------------
| المسارات الخاصة بلوحة التحكم
|--------------------------------------------------------------------------
*/
// مسارات تسجيل الدخول والخروج تبقى منفصلة
Route::get('/admin/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/admin/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// مجموعة لكل مسارات لوحة التحكم التي تتطلب تسجيل الدخول
Route::prefix('admin')->middleware('auth')->name('admin.')->group(function () {
    
    // لوحة التحكم الرئيسية
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // إدارة الطلاب
    Route::get('/students', [AdminStudentController::class, 'index'])->name('students.index');

    // يمكن إضافة مسارات أخرى هنا مستقبلاً
});