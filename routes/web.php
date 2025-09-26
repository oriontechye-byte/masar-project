<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\StudentController;

Route::get('/', function () {
    // We can later make this the registration page
    return redirect('/register');
});

// Test Routes
Route::get('/test', [TestController::class, 'showTest']);
Route::post('/submit-test', [TestController::class, 'calculateResult']);

// Student Registration Routes
Route::get('/register', [StudentController::class, 'showRegistrationForm']);
Route::post('/register', [StudentController::class, 'register']); // This will now just lead to the test
// Routes for the post-lecture test lookup
Route::get('/post-test', [App\Http\Controllers\StudentController::class, 'showPostTestLookupForm']);
Route::post('/post-test', [App\Http\Controllers\StudentController::class, 'handlePostTestLookup']);