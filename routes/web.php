<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\OfferingController;
use App\Http\Controllers\TransferController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Member Management
    Route::resource('members', MemberController::class);
    Route::get('/members-inactive', [MemberController::class, 'inactive'])->name('members.inactive');
    Route::get('/members-search', [MemberController::class, 'search'])->name('members.search');

    // Finance Management
    Route::resource('offerings', OfferingController::class);
    Route::get('/finance-tithe', [OfferingController::class, 'tithe'])->name('offerings.tithe');
    Route::get('/finance-funds', [OfferingController::class, 'funds'])->name('offerings.funds');
    Route::get('/finance-receipts', [OfferingController::class, 'receipts'])->name('offerings.receipts');
    Route::get('/finance-bulk', [OfferingController::class, 'bulk'])->name('offerings.bulk');

    // Transfer Management
    Route::resource('transfers', TransferController::class);
    Route::get('/transfers-pending', [TransferController::class, 'pending'])->name('transfers.pending');
    Route::get('/transfers-history', [TransferController::class, 'history'])->name('transfers.history');

    // Event Management
    Route::resource('events', EventController::class);
    Route::get('/events-attendance', [EventController::class, 'attendance'])->name('events.attendance');

    // User Management
    Route::resource('users', UserController::class);
    Route::get('/users-roles', [UserController::class, 'roles'])->name('users.roles');
    Route::get('/users-audit', [UserController::class, 'audit'])->name('users.audit');

    // Reports
    Route::get('/reports/membership', [ReportController::class, 'membership'])->name('reports.membership');
    Route::get('/reports/finance', [ReportController::class, 'finance'])->name('reports.finance');
    Route::get('/reports/attendance', [ReportController::class, 'attendance'])->name('reports.attendance');
    Route::get('/reports/transfers', [ReportController::class, 'transfers'])->name('reports.transfers');

    // Settings
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings/update', [SettingController::class, 'update'])->name('settings.update');
});

// Password reset routes (placeholders)
Route::get('/forgot-password', function () {
    return view('auth.login'); // Redirect to login or show a reset view
})->name('password.request');
