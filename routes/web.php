<?php

use App\Livewire\CustomerBooking;
use App\Livewire\UserBookings;
use Illuminate\Support\Facades\Route;

Route::get('/', CustomerBooking::class)->name('home');

Route::middleware(['auth'])->group(function () {
    Route::get('/bookings', UserBookings::class)->name('bookings');
    Route::view('/profile', 'profile')->name('profile');
});

Route::get('/dashboard', function () {
    if (auth()->user()->role !== 'admin') {
        return redirect()->route('bookings');
    }

    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__ . '/auth.php';
