<?php

namespace App\Livewire;

use App\Models\Appointment;
use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Component;
use PhpParser\Builder;

#[Layout('layouts.app')]
class UserBookings extends Component
{

    public bool $showCancelModal = false;
    public ?Appointment $selectedAppointment = null;

    // --- RESCHEDULE STATE ---
    public bool $showRescheduleModal = false;
    public ?Appointment $rescheduleAppointment = null;
    public string $rescheduleDate = '';
    public string $rescheduleViewDate = '';
    public ?string $rescheduleTime = null;

    public function confirmReschedule(int $id): void
    {
        $this->rescheduleAppointment = Appointment::with(['service', 'employee'])->findOrFail($id);

        $this->rescheduleDate = Carbon::tomorrow()->format('Y-m-d');
        $this->rescheduleViewDate = Carbon::today()->startOfMonth()->format('Y-m-d');
        $this->rescheduleTime = null;

        $this->showRescheduleModal = true;
    }

    public function selectRescheduleDate(string $date): void
    {
        $this->rescheduleDate = $date;
        $this->rescheduleTime = null;
    }

    public function selectRescheduleTime(string $time): void
    {
        $this->rescheduleTime = $time;
    }

    public function nextRescheduleMonth(): void
    {
        $this->rescheduleViewDate = Carbon::parse($this->rescheduleViewDate)->addMonth()->format('Y-m-d');
    }

    public function previousRescheduleMonth(): void
    {
        $newDate = Carbon::parse($this->rescheduleViewDate)->subMonth();

        if ($newDate->isBefore(Carbon::tomorrow()->startOfMonth())) {
            return;
        }

        $this->rescheduleViewDate = $newDate->format('Y-m-d');
    }

    public function rescheduleSlots(): array
    {
        if (!$this->rescheduleAppointment || !$this->rescheduleDate) {
            return [];
        }

        $employeeId = $this->rescheduleAppointment->employee_id;
        $duration = $this->rescheduleAppointment->service->duration;
        $date = Carbon::parse($this->rescheduleDate);
        $dayOfWeek = $date->dayOfWeek;

        $workDay = Schedule::where('user_id', $employeeId)->where('day_of_week', $dayOfWeek)->first();

        $existingBookings = Appointment::where('employee_id', $employeeId)
            ->whereDate('start_time', $this->rescheduleDate)
            ->where('id', '!=', $this->rescheduleAppointment->id)
            ->get();


        $slots = [];
        $start = Carbon::parse($workDay->start_time);
        $end = Carbon::parse($workDay->end_time);

        while ($start < $end) {
            $potentialStart = Carbon::parse($this->rescheduleDate . ' ' . $start->format('H:i:s'));
            $potentialEnd = (clone $potentialStart)->addMinutes($duration);

            $isOverlapping = $existingBookings->contains(function ($booking) use ($potentialStart, $potentialEnd) {
                $bookingStart = Carbon::parse($booking->start_time);
                $bookingEnd = Carbon::parse($booking->end_time);
                return $potentialStart->lt($bookingEnd) && $potentialEnd->gt($bookingStart);
            });

            $isWithinShift = $potentialEnd <= Carbon::parse($this->rescheduleDate . ' ' . $workDay->end_time);
            $isPast = $potentialStart->isBefore(Carbon::now());

            $slots[] = [
                'time' => $start->format('H:i A'),
                'raw' => $start->format('H:i:s'),
                'available' => !$isOverlapping && $isWithinShift && !$isPast
            ];

            $start->addMinutes(30);
        }

        return $slots;
    }

    public function processReschedule(): void
    {
        $this->validate([
            'rescheduleDate' => 'required|date',
            'rescheduleTime' => 'required'
        ]);

        $start = Carbon::parse($this->rescheduleDate . ' ' . $this->rescheduleTime);
        $end = (clone $start)->addMinutes($this->rescheduleAppointment->service->duration);

        $this->rescheduleAppointment->update([
            'start_time' => $start,
            'end_time' => $end,
        ]);

        $this->showRescheduleModal = false;
        $this->rescheduleAppointment = null;

        unset($this->upcomingAppointments);
        $this->dispatch('notify', ['message' => 'Appointment rescheduled successfully.']);
    }

    #[Computed]
    public function upcomingAppointments()
    {
        return Appointment::where('user_id', Auth::id())
            ->where('start_time', '>=', Carbon::now())
            ->where('status', Appointment::STATUS_CONFIRMED)
            ->with(['service', 'employee'])
            ->get();
    }

    #[Computed]
    public function appointmentHistory()
    {
        return Appointment::where('user_id', Auth::id())
            ->where(function ($query) {
                $query->where('start_time', '<', Carbon::now())
                    ->orWhere('status', Appointment::STATUS_CANCELLED);
            })
            ->with(['service', 'employee'])
            ->orderByDesc('start_time')
            ->take(5) //Limit to 5 appointemnts for the dashboard
            ->get();
    }

    public function cancelAppointment(): void
    {
        if ($this->selectedAppointment) {
            $this->selectedAppointment->update(['status' => Appointment::STATUS_CANCELLED]);

            $this->selectedAppointment = null;
            $this->showCancelModal = false;

            unset($this->upcomingAppointments); // Clear the cache for upcoming appointments
            unset($this->appointmentHistory); // Clear the cache for appointment history

            $this->dispatch('notify', ['message' => 'Appointment cancelled successfully.']);
        }
    }

    public function confirmCancel($id): void
    {
        $this->selectedAppointment = Appointment::with('service', 'employee')->findOrFail($id);
        $this->showCancelModal = true;
    }

    public function render(): View
    {
        return view('livewire.pages.bookings.user-bookings');
    }
}
