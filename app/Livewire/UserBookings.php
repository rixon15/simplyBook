<?php

namespace App\Livewire;

use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Component;
use PhpParser\Builder;

#[Layout('layouts.app')]
class UserBookings extends Component
{

    #[Computed]
    public function upcomingAppointments()
    {
        return Appointment::where('user_id', Auth::id())
            ->where('start_time', '>=', Carbon::now())
            ->where('status', 'confirmed')
            ->with(['service', 'employee'])
            ->get();
    }

    #[Computed]
    public function appointmentHistory()
    {
        return Appointment::where('user_id', Auth::id())
            ->where(function ($query) {
                $query->where('start_time', '<', Carbon::now())
                    ->orWhere('status', 'cancelled');
            })
            ->with(['service', 'employee'])
            ->orderByDesc('start_time')
            ->take(5) //Limit to 5 appointemnts for the dashboard
            ->get();
    }

    public function cancelAppointment(int $id): void
    {
        $appointement = Appointment::where('user_id', Auth::id()->findOrFail($id));

        $appointement->update(['status' => 'cancelled']);

        session()->flash('message', 'Appointment cancelled successfully.');
    }

    public function render(): View
    {
        return view('livewire.pages.bookings.user-bookings');
    }
}
