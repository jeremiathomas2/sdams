<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\OfferingController;
use App\Http\Controllers\TransferController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

Route::middleware('guest')->group(function () {
    Route::get('/', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // My Profile - all authenticated users
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Member Management - Administrator, Pastor, Membership Clerk
    Route::middleware('role:Administrator,Pastor,Membership Clerk')->group(function () {
        Route::resource('members', MemberController::class);
        Route::get('/members-inactive', [MemberController::class, 'inactive'])->name('members.inactive');
        Route::get('/members-search', [MemberController::class, 'search'])->name('members.search');
        Route::get('/members-export', [MemberController::class, 'export'])->name('members.export');
    });

    // Finance Management - Administrator, Finance Clerk
    Route::middleware('role:Administrator,Finance Clerk')->group(function () {
        Route::resource('offerings', OfferingController::class);
        Route::get('/finance-tithe', [OfferingController::class, 'tithe'])->name('offerings.tithe');
        Route::get('/finance-funds', [OfferingController::class, 'funds'])->name('offerings.funds');
        Route::post('/finance-funds', [OfferingController::class, 'storeFund'])->name('offerings.storeFund');
        Route::get('/finance-funds/{fund}/edit', [OfferingController::class, 'editFund'])->name('offerings.editFund');
        Route::put('/finance-funds/{fund}', [OfferingController::class, 'updateFund'])->name('offerings.updateFund');
        Route::delete('/finance-funds/{fund}', [OfferingController::class, 'destroyFund'])->name('offerings.destroyFund');
        Route::get('/finance-receipts', [OfferingController::class, 'receipts'])->name('offerings.receipts');
        Route::get('/finance-bulk', [OfferingController::class, 'bulk'])->name('offerings.bulk');
        Route::post('/finance-bulk', [OfferingController::class, 'bulkStore'])->name('offerings.bulkStore');
        Route::get('/finance-export', [OfferingController::class, 'export'])->name('offerings.export');
    });

    // Transfer Management - Administrator, Pastor, Membership Clerk
    Route::middleware('role:Administrator,Pastor,Membership Clerk')->group(function () {
        Route::resource('transfers', TransferController::class);
        Route::get('/transfers-pending', [TransferController::class, 'pending'])->name('transfers.pending');
        Route::get('/transfers-history', [TransferController::class, 'history'])->name('transfers.history');
    });

    // Event Management - All authenticated users
    Route::resource('events', EventController::class);
    Route::get('/events-attendance', [EventController::class, 'attendance'])->name('events.attendance');
    Route::post('/events-attendance', [AttendanceController::class, 'store'])->name('events.attendance.store');

    // User Management - Administrator only
    Route::middleware('role:Administrator')->group(function () {
        Route::resource('users', UserController::class);
        Route::get('/users-roles', [UserController::class, 'roles'])->name('users.roles');
        Route::get('/users-audit', [UserController::class, 'audit'])->name('users.audit');
        Route::get('/users-audit/export', [UserController::class, 'auditExport'])->name('users.auditExport');
    });

    // Reports - Administrator, Pastor
    Route::middleware('role:Administrator,Pastor')->group(function () {
        Route::get('/reports/membership', [ReportController::class, 'membership'])->name('reports.membership');
        Route::get('/reports/finance', [ReportController::class, 'finance'])->name('reports.finance');
        Route::get('/reports/attendance', [ReportController::class, 'attendance'])->name('reports.attendance');
        Route::get('/reports/transfers', [ReportController::class, 'transfers'])->name('reports.transfers');
    });

    // Settings
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings/update', [SettingController::class, 'update'])->name('settings.update');
});

// Password reset routes
Route::middleware('guest')->group(function () {
    Route::get('/forgot-password', function () {
        return view('auth.forgot-password');
    })->name('password.request');

    Route::post('/forgot-password', function (Request $request) {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', __($status))
            : back()->withErrors(['email' => __($status)]);
    })->name('password.email');

    Route::get('/reset-password/{token}', function ($token) {
        return view('auth.reset-password', ['token' => $token]);
    })->name('password.reset');

    Route::post('/reset-password', function (Request $request) {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['email' => __($status)]);
    })->name('password.update');
});
