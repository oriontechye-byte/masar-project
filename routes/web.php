<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\StudentController as AdminStudentController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Admin\IntelligenceTypeController;
use App\Http\Controllers\PageController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [PageController::class, 'showLandingPage'])->name('landing');

// Student & Test routes
Route::get('/register', [StudentController::class, 'showRegistrationForm']);
Route::post('/register', [StudentController::class, 'register']);
Route::get('/post-test', [StudentController::class, 'showPostTestLookupForm']);
Route::post('/post-test', [StudentController::class, 'handlePostTestLookup']);
Route::get('/test', [TestController::class, 'showTest']);
Route::post('/submit-test', [TestController::class, 'calculateResult']);
Route::get('/results/{student_id}', [StudentController::class, 'showStudentResults'])->name('results.show');

/*
|--------------------------------------------------------------------------
| Admin Panel Routes
|--------------------------------------------------------------------------
*/
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::prefix('admin')->middleware('auth')->name('admin.')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Students Management
    Route::get('/students', [AdminStudentController::class, 'index'])->name('students.index');
    Route::get('/students/export', [AdminStudentController::class, 'export'])->name('students.export');
    Route::get('/students/{id}', [AdminStudentController::class, 'show'])->name('students.show');

    // Questions Management
    Route::resource('questions', QuestionController::class)->except(['show']);

    // Intelligence Types Management
    Route::get('/types', [IntelligenceTypeController::class, 'index'])->name('types.index');
    Route::get('/types/{id}/edit', [IntelligenceTypeController::class, 'edit'])->name('types.edit');
    Route::put('/types/{id}', [IntelligenceTypeController::class, 'update'])->name('types.update');
});
