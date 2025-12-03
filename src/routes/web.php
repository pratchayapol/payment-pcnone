<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Auth;


Route::get('/', function () {
    return view('welcome');
});

// Google OAuth
Route::get('auth/google', [GoogleController::class, 'redirect'])->name('google.redirect');
Route::get('auth/google/callback', [GoogleController::class, 'callback'])->name('google.callback');

// กำหนด route login ให้ middleware auth ใช้
Route::get('/login', function () {
    return redirect()->route('google.redirect');
})->name('login');

// หน้า user ต้อง login ก่อน
Route::get('/user', [UserController::class, 'index'])
    ->name('user.index')
    ->middleware('auth');

// อัปโหลดสลิป
Route::post('/upload-slip', [UserController::class, 'uploadSlip'])->name('upload.slip');

// logout
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');

Route::get('/user/profile', [UserController::class, 'profile'])->name('user.profile');
Route::get('/user/payments', [UserController::class, 'payments'])->name('user.payments');

Route::middleware(['auth'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
});

Route::get('/admin/profile', [AdminController::class, 'profile'])->name('admin.profile');
Route::get('/admin/checkpayments/{id}', [AdminController::class, 'checkPayments'])->name('admin.checkpayments');
Route::post('/admin/verifyslip/{paymentId}', [AdminController::class, 'verifySlip'])->name('admin.verifyslip');
