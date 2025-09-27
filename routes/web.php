<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\Auth\LoginController;

/*
|--------------------------------------------------------------------------
| Student Facing Routes
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return redirect('/register');
});

// Student Registration & Test
Route::get('/register', [StudentController::class, 'showRegistrationForm']);
Route::post('/register', [StudentController::class, 'register']);
Route::get('/post-test', [StudentController::class, 'showPostTestLookupForm']);
Route::post('/post-test', [StudentController::class, 'handlePostTestLookup']);

// Test Flow
Route::get('/test', [TestController::class, 'showTest']);
Route::post('/submit-test', [TestController::class, 'calculateResult']);
Route::get('/results/{student_id}', [StudentController::class, 'showStudentResults'])->name('results.show');

/*
|--------------------------------------------------------------------------
| Admin Panel Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->group(function () {
    // Login Routes
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    // Routes that require authentication
    Route::middleware('auth')->group(function () {
        Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
        
        // Dashboard (we will create this in the next step)
        Route::get('/dashboard', function () {
            return 'أهلاً بك في لوحة التحكم!';
        })->name('admin.dashboard');

        // Other admin routes will go here in the future
    });
});

