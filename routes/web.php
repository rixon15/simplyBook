<?php

use App\Http\Middleware\EnsureUserIsAdmin;
use App\Http\Middleware\EnsureUserIsCustomer;
use App\Http\Middleware\EnsureUserIsEmployee;
use App\Livewire\CustomerBooking;
use App\Livewire\Pages\Admin\Appointments;
use App\Livewire\Pages\Admin\Dashboard as AdminDashboard;
use App\Livewire\Pages\Admin\Payments;
use App\Livewire\Pages\Admin\Services;
use App\Livewire\Pages\Admin\Staff;
use App\Livewire\Pages\EmployeeDashboard\Dashboard as EmployeeDashboard;
use App\Livewire\Pages\Notifications\Notifications;
use App\Livewire\UserBookings;
use App\Livewire\UserProfile;
use Illuminate\Support\Facades\Route;

Route::get('/admin', function () {
    if (auth()->user()->role == 'admin' || auth()->user()->role == 'employee') {
        return redirect()->route('dashboard');
    }

    return redirect()->route('home');
})->middleware(['auth', 'verified'])->name('admin');

Route::middleware(['auth', 'verified', EnsureUserIsCustomer::class])->group(function () {
    Route::get('/bookings', UserBookings::class)->name('bookings');
    Route::get('/notifications', Notifications::class)->name('notifications');
    Route::get('/profile', UserProfile::class)->name('profile');
    Route::get('/', CustomerBooking::class)->name('home');
});

Route::prefix('admin')->middleware(['auth', 'verified', EnsureUserIsAdmin::class])->group(function () {
    Route::get('dashboard', AdminDashboard::class)->name('dashboard');
    Route::get('appointment', Appointments::class)->name('appointments');
    Route::get('services', Services::class)->name('admin.services');
    Route::get('staff', Staff::class)->name('admin.staff');
    Route::get('payments', Payments::class)->name('admin.payments');
    Route::get('profile', UserProfile::class)->name('admin.profile');
    Route::get('notifications', Notifications::class)->name('admin.notifications');
});

Route::prefix('employee')->middleware(['auth', 'verified', EnsureUserIsEmployee::class])->group(function () {
    Route::get('dashboard', EmployeeDashboard::class)->name('dashboard'); // employee.dashboard
    Route::get('notifications', Notifications::class)->name('employee.notifications'); // employee.notifications
});

require __DIR__ . '/auth.php';
