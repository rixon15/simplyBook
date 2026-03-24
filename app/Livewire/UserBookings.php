<?php

namespace App\Livewire;

use App\Models\Appointment;
use App\Models\Schedule;
use App\Notifications\AppNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Component;
use PhpParser\Builder;
use PHPUnit\TextUI\Application;

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

    private string $TIME_FORMAT = 'M j @ g:i A';

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

        $schedule = Schedule::where('user_id', $employeeId)->where('day_of_week', $dayOfWeek)->first();

        if (!$schedule) {
            return [];
        }

        $existingBookings = Appointment::where('employee_id', $employeeId)
            ->whereDate('start_time', $this->rescheduleDate)
            ->where('id', '!=', $this->rescheduleAppointment->id)
            ->get();


        $slots = [];
        $start = Carbon::parse($schedule->start_time);
        $end = Carbon::parse($schedule->end_time);

        while ($start < $end) {
            $potentialStart = Carbon::parse($this->rescheduleDate . ' ' . $start->format('H:i:s'));
            $potentialEnd = (clone $potentialStart)->addMinutes($duration);

            $isOverlapping = $existingBookings->contains(function ($booking) use ($potentialStart, $potentialEnd) {
                $bookingStart = Carbon::parse($booking->start_time);
                $bookingEnd = Carbon::parse($booking->end_time);
                return $potentialStart->lt($bookingEnd) && $potentialEnd->gt($bookingStart);
            });

            $isWithinShift = $potentialEnd <= Carbon::parse($this->rescheduleDate . ' ' . $schedule->end_time);
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

        $appointment = $this->rescheduleAppointment;
        if (!$appointment) return;

        $actor = Auth::user();

        $start = Carbon::parse($this->rescheduleDate . ' ' . $this->rescheduleTime);
        $end = (clone $start)->addMinutes($this->rescheduleAppointment->service->duration);

        $oldTimeFormatted = $appointment->start_time->format($this->TIME_FORMAT);
        $newTimeFormatted = $start->format($this->TIME_FORMAT);

        $appointment->update([
            'start_time' => $start,
            'end_time' => $end,
        ]);

        if ($actor->id === $appointment->user_id) {

            // SCENARIO A: The CUSTOMER is rescheduling their own appointment

            $actor->notify(new AppNotification(
                'info',
                'Reschedule Confirmed',
                "You successfully moved your appointment to {$newTimeFormatted}."
            ));

            if ($appointment->employee) {
                $appointment->employee->notify(new AppNotification(
                    'info',
                    'Client Rescheduled',
                    "{$actor->name} moved their appointment from {$oldTimeFormatted} to {$newTimeFormatted}.}"
                ));
            }

        } else {

            if ($appointment->user) {
                $appointment->user->notify(new AppNotification(
                    'info',
                    'Appointment Changed',
                    "Your appointment was rescheduled to {$newTimeFormatted} by {$actor->name}}"
                ));
            }

        }

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

        $appointment = $this->selectedAppointment;

        if (!$appointment) {
            return;
        }

        $actor = Auth::user();

        $appointment->update(['status' => Appointment::STATUS_CANCELLED]);

        if ($actor->id === $appointment->user_id) {

            // SCENARIO A: The CUSTOMER is cancelling their own appointment

            // 1. Send a receipt to the Customer
            $actor->notify(new AppNotification(
                'info',
                'Cancellation Confimed',
                'You successfully cancelled your appointment for ' . $appointment->start_time->format($this->TIME_FORMAT) . '.'
            ));

            // 2. Alert the Employee that their calendar opened up
            if ($appointment->employee) {
                $appointment->employee->notify(new AppNotification(
                    'error',
                    'Client Cancelled',
                    $actor->name . ' cancelled their appointment for ' . $appointment->start_time->format($this->TIME_FORMAT) . '.'
                ));
            }

        } else {

            // SCENARIO B: An ADMIN or EMPLOYEE is cancelling the appointmen

            // 1. Alert the Customer that their appointment was cancelled by staff
            if ($appointment->user()) {
                $appointment->user()->notify(new AppNotification(
                    'error',
                    'Appointment Cancelled',
                    'Your appointment on ' . $appointment->start_time->format($this->TIME_FORMAT) . '.'
                ));
            }

            // 2. (Optional) Audit trail for the Admin
            $actor->notify(new AppNotification(
                'info',
                'Cancellation Proccessed',
                'You cancelled the appointment for ' . $appointment->user->name . '.'
            ));
        }

        $this->selectedAppointment = null;
        $this->showCancelModal = false;

        unset($this->upcomingAppointments); // Clear the cache for upcoming appointments
        unset($this->appointmentHistory); // Clear the cache for appointment history

        $this->dispatch('notify', ['message' => 'Appointment cancelled successfully.']);
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
