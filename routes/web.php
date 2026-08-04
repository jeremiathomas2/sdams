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

    // ---- Member Management ----
    Route::middleware('permission:members.create')->group(function () {
        Route::get('/members/create', [MemberController::class, 'create'])->name('members.create');
        Route::post('/members', [MemberController::class, 'store'])->name('members.store');
    });
    Route::middleware('permission:members.edit')->group(function () {
        Route::get('/members/{member}/edit', [MemberController::class, 'edit'])->name('members.edit');
        Route::put('/members/{member}', [MemberController::class, 'update'])->name('members.update');
    });
    Route::middleware('permission:members.delete')->group(function () {
        Route::delete('/members/{member}', [MemberController::class, 'destroy'])->name('members.destroy');
    });
    Route::middleware('permission:members.view')->group(function () {
        Route::get('/members', [MemberController::class, 'index'])->name('members.index');
        Route::get('/members-inactive', [MemberController::class, 'inactive'])->name('members.inactive');
        Route::get('/members-search', [MemberController::class, 'search'])->name('members.search');
        Route::get('/members/{member}', [MemberController::class, 'show'])->name('members.show');
    });
    Route::middleware('permission:members.export')->group(function () {
        Route::get('/members-export', [MemberController::class, 'export'])->name('members.export');
    });

    // ---- Finance Management ----
    Route::middleware('permission:finance.create')->group(function () {
        Route::get('/offerings/create', [OfferingController::class, 'create'])->name('offerings.create');
        Route::post('/offerings', [OfferingController::class, 'store'])->name('offerings.store');
    });
    Route::middleware('permission:finance.edit')->group(function () {
        Route::get('/offerings/{offering}/edit', [OfferingController::class, 'edit'])->name('offerings.edit');
        Route::put('/offerings/{offering}', [OfferingController::class, 'update'])->name('offerings.update');
    });
    Route::middleware('permission:finance.delete')->group(function () {
        Route::delete('/offerings/{offering}', [OfferingController::class, 'destroy'])->name('offerings.destroy');
    });
    Route::middleware('permission:finance.view')->group(function () {
        Route::get('/offerings', [OfferingController::class, 'index'])->name('offerings.index');
        Route::get('/finance-tithe', [OfferingController::class, 'tithe'])->name('offerings.tithe');
        Route::get('/finance-receipts', [OfferingController::class, 'receipts'])->name('offerings.receipts');
        Route::get('/offerings/{offering}', [OfferingController::class, 'show'])->name('offerings.show');
    });
    Route::middleware('permission:finance.funds')->group(function () {
        Route::get('/finance-funds', [OfferingController::class, 'funds'])->name('offerings.funds');
        Route::post('/finance-funds', [OfferingController::class, 'storeFund'])->name('offerings.storeFund');
        Route::get('/finance-funds/{fund}/edit', [OfferingController::class, 'editFund'])->name('offerings.editFund');
        Route::put('/finance-funds/{fund}', [OfferingController::class, 'updateFund'])->name('offerings.updateFund');
        Route::delete('/finance-funds/{fund}', [OfferingController::class, 'destroyFund'])->name('offerings.destroyFund');
    });
    Route::middleware('permission:finance.bulk')->group(function () {
        Route::get('/finance-bulk', [OfferingController::class, 'bulk'])->name('offerings.bulk');
        Route::post('/finance-bulk', [OfferingController::class, 'bulkStore'])->name('offerings.bulkStore');
    });
    Route::middleware('permission:finance.export')->group(function () {
        Route::get('/finance-export', [OfferingController::class, 'export'])->name('offerings.export');
    });

    // ---- Transfer Management ----
    Route::middleware('permission:transfers.create')->group(function () {
        Route::get('/transfers/create', [TransferController::class, 'create'])->name('transfers.create');
        Route::post('/transfers', [TransferController::class, 'store'])->name('transfers.store');
    });
    Route::middleware('permission:transfers.edit')->group(function () {
        Route::get('/transfers/{transfer}/edit', [TransferController::class, 'edit'])->name('transfers.edit');
        Route::put('/transfers/{transfer}', [TransferController::class, 'update'])->name('transfers.update');
    });
    Route::middleware('permission:transfers.delete')->group(function () {
        Route::delete('/transfers/{transfer}', [TransferController::class, 'destroy'])->name('transfers.destroy');
    });
    Route::middleware('permission:transfers.view')->group(function () {
        Route::get('/transfers', [TransferController::class, 'index'])->name('transfers.index');
        Route::get('/transfers-pending', [TransferController::class, 'pending'])->name('transfers.pending');
        Route::get('/transfers-history', [TransferController::class, 'history'])->name('transfers.history');
        Route::get('/transfers/{transfer}', [TransferController::class, 'show'])->name('transfers.show');
    });

    // ---- Event Management & Attendance ----
    Route::middleware('permission:events.create')->group(function () {
        Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
        Route::post('/events', [EventController::class, 'store'])->name('events.store');
    });
    Route::middleware('permission:events.edit')->group(function () {
        Route::get('/events/{event}/edit', [EventController::class, 'edit'])->name('events.edit');
        Route::put('/events/{event}', [EventController::class, 'update'])->name('events.update');
    });
    Route::middleware('permission:events.delete')->group(function () {
        Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('events.destroy');
    });
    Route::middleware('permission:events.view')->group(function () {
        Route::get('/events', [EventController::class, 'index'])->name('events.index');
        Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');
    });
    Route::middleware('permission:events.attendance')->group(function () {
        Route::get('/events-attendance', [EventController::class, 'attendance'])->name('events.attendance');
        Route::post('/events-attendance', [AttendanceController::class, 'store'])->name('events.attendance.store');
    });

    // ---- User Management ----
    Route::middleware('permission:users.create')->group(function () {
        Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
    });
    Route::middleware('permission:users.edit')->group(function () {
        Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    });
    Route::middleware('permission:users.delete')->group(function () {
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    });
    Route::middleware('permission:users.view')->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
    });

    // ---- Roles & Permissions ----
    Route::middleware('permission:roles.manage')->group(function () {
        Route::get('/users-roles', [UserController::class, 'roles'])->name('users.roles');
        Route::post('/users-roles', [UserController::class, 'storeRole'])->name('roles.store');
        Route::put('/users-roles/{role}', [UserController::class, 'updateRole'])->name('roles.update');
        Route::delete('/users-roles/{role}', [UserController::class, 'destroyRole'])->name('roles.destroy');
        Route::put('/users-roles/{role}/permissions', [UserController::class, 'syncPermissions'])->name('roles.permissions');
    });

    // ---- Audit Logs ----
    Route::middleware('permission:audit.view')->group(function () {
        Route::get('/users-audit', [UserController::class, 'audit'])->name('users.audit');
    });
    Route::middleware('permission:audit.export')->group(function () {
        Route::get('/users-audit/export', [UserController::class, 'auditExport'])->name('users.auditExport');
    });

    // ---- Reports ----
    Route::middleware('permission:reports.view')->group(function () {
        Route::get('/reports/membership', [ReportController::class, 'membership'])->name('reports.membership');
        Route::get('/reports/finance', [ReportController::class, 'finance'])->name('reports.finance');
        Route::get('/reports/attendance', [ReportController::class, 'attendance'])->name('reports.attendance');
        Route::get('/reports/transfers', [ReportController::class, 'transfers'])->name('reports.transfers');
    });

    // ---- Settings ----
    Route::middleware('permission:settings.manage')->group(function () {
        Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
        Route::post('/settings/update', [SettingController::class, 'update'])->name('settings.update');
    });
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
