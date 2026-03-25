<?php

use App\Livewire\CustomerBooking;
use App\Livewire\Pages\Notifications\Notifications;
use App\Livewire\UserBookings;
use App\Livewire\UserProfile;
use Illuminate\Support\Facades\Route;

Route::get('/', CustomerBooking::class)->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/bookings', UserBookings::class)->name('bookings');
    Route::get('/profile', UserProfile::class)->name('profile');
    Route::get('/notifications', Notifications::class)->name('notifications');
});

Route::get('/dashboard', function () {
    if (auth()->user()->role !== 'admin') {
        return redirect()->route('bookings');
    }

    return view('dashboard');
})->middleware(['auth'])->name('dashboard');


require __DIR__ . '/auth.php';
