<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OtpController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\TripController;
use App\Http\Controllers\CheckInController;
use App\Http\Controllers\ExpenseController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\Feedback;

// ======================
// PUBLIC AUTH ROUTES
// ======================
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::get('/system-owner-portal', [AuthController::class, 'showSystemOwnerLoginForm'])->name('system-owner.portal');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Google Socialite Login
Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('google.login');
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback'])->name('google.callback');

// Registration
Route::get('/register', function () {
    return view('auth.register');
})->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

// Password Reset
Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

// OTP Routes
Route::get('/otp/send', [OtpController::class, 'sendOtp'])->name('otp.send');
Route::get('/otp/verify', [OtpController::class, 'showVerifyForm'])->name('otp.form');
Route::post('/otp/verify', [OtpController::class, 'verifyOtp'])->name('otp.verify');

// Registration Pending
Route::get('/registration-pending', function () {
    return view('auth.registration-pending');
})->name('registration-pending');

// ======================
// AUTHENTICATED ROUTES
// ======================
Route::middleware('auth')->group(function () {
    // Home/Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/home', [DashboardController::class, 'index'])->name('home');

    // Account Management
    Route::get('/account', [AccountController::class, 'index'])->name('account.index');
    Route::post('/account/profile', [AccountController::class, 'updateProfile'])->name('account.profile.update');
    Route::post('/account/password', [AccountController::class, 'updatePassword'])->name('account.password.update');
    Route::get('/account/password/otp', [AccountController::class, 'showPasswordOtpForm'])->name('account.password.otp');
    Route::post('/account/password/otp', [AccountController::class, 'verifyPasswordOtp'])->name('account.password.otp.verify');
    Route::get('/account/password/resend-otp', [AccountController::class, 'resendPasswordOtp'])->name('account.password.otp.resend');

    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/read/{notification}', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.readAll');

    // ======================
    // KTV MANAGEMENT ROUTES
    // ======================
    
    // Drivers
    Route::resource('drivers', DriverController::class);
    
    // Vehicles
    Route::resource('vehicles', VehicleController::class);
    
    // Routes
    Route::resource('routes', RouteController::class);
    
    // Trips
    Route::resource('trips', TripController::class);
    Route::post('/trips/{trip}/start', [TripController::class, 'startTrip'])->name('trips.start');
    Route::post('/trips/{trip}/end', [TripController::class, 'endTrip'])->name('trips.end');
    
    // Check-ins
    Route::post('/checkins', [CheckInController::class, 'store'])->name('checkins.store');
    Route::get('/trips/{trip}/checkins', [CheckInController::class, 'tripCheckins'])->name('checkins.trip');
    
    // Expenses
    Route::resource('expenses', ExpenseController::class)->only(['index', 'create', 'store']);
    Route::get('/expenses/report', [ExpenseController::class, 'report'])->name('expenses.report');

    // Feedback
    Route::get('/feedback', function () {
        return view('feedback');
    })->name('feedback');
    Route::post('/feedback', function (\Illuminate\Http\Request $request) {
        Feedback::create([
            'user_id' => Auth::id(),
            'title' => $request->topic,
            'context' => $request->message,
        ]);
        return back()->with('success', 'Feedback sent successfully!');
    });
});

// ======================
// ADMIN ROUTES
// ======================
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Admin Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Admin Management
    Route::get('/management', function () {
        return view('admin.home', [
            'activeTab' => 'management',
            'pageTitle' => 'Management',
        ]);
    })->name('management');

    // Feedback Management
    Route::get('/feedback', function () {
        $feedbacks = Feedback::with('user')->latest()->get();
        return view('admin.home', [
            'activeTab' => 'feedback',
            'pageTitle' => 'Feedback',
            'feedbacks' => $feedbacks,
        ]);
    })->name('feedback');

    Route::post('/feedback/{feedback}/reply', function (\Illuminate\Http\Request $request, Feedback $feedback) {
        $request->validate(['reply_message' => 'required|string']);
        if ($feedback->user && $feedback->user->email) {
            try {
                \Illuminate\Support\Facades\Mail::to($feedback->user->email)->send(
                    new \App\Mail\FeedbackReplyMail($feedback->title, $request->reply_message)
                );
                return back()->with('success', 'Reply sent successfully');
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Mail Error: ' . $e->getMessage());
                return back()->with('error', 'Mail error: ' . $e->getMessage());
            }
        }
        return back()->with('error', 'User has no valid email');
    })->name('feedback.reply');

    Route::delete('/feedback/{feedback}', function (Feedback $feedback) {
        $feedback->delete();
        return back()->with('success', 'Feedback deleted successfully');
    })->name('feedback.destroy');

    // User Management (System Owner Only)
    Route::middleware(['system_owner'])->group(function () {
        Route::resource('users', App\Http\Controllers\Admin\UserController::class);
        Route::get('/users-approval', [App\Http\Controllers\Admin\UserController::class, 'approvalPanel'])->name('users.approval-panel');
        Route::post('/users/{user}/approve', [App\Http\Controllers\Admin\UserController::class, 'approve'])->name('users.approve');
        Route::post('/users/{user}/reject', [App\Http\Controllers\Admin\UserController::class, 'reject'])->name('users.reject');
    });
});

// Language Switcher
Route::get('/language/{locale}', function (string $locale) {
    abort_unless(in_array($locale, ['vi', 'en'], true), 404);
    session(['locale' => $locale]);
    return back();
})->name('language.switch');
