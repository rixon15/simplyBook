<?php

namespace App\Livewire;

use App\Models\Appointment;
use App\Models\Schedule;
use App\Models\Service;
use App\Models\User;
use App\Notifications\AppNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\Attributes\Computed;

class CustomerBooking extends Component
{

    public Collection $services;
    public Collection $employees;

    public ?int $selectedServiceId = null;
    public ?int $selectedEmployeeId = null;
    public string $selectedDate;
    public ?string $selectedTime = null;

    public string $viewDate;

    public bool $showSuccess = false;


    public function mount(): void
    {
        $this->services = Service::all();
        $this->employees = User::where('role', 'employee')->get();

        $this->selectedDate = Carbon::tomorrow()->format('Y-m-d');
        $this->viewDate = Carbon::today()->startofMonth()->format('Y-m-d');

        $this->selectedServiceId = $this->services->first()?->id;
        $this->selectedEmployeeId = $this->employees->first()?->id;
    }

    public function goToNextMonth(): void
    {
        $this->viewDate = Carbon::parse($this->viewDate)->addMonth()->format('Y-m-d');
    }

    public function goToPreviousMonth(): void
    {
        $newDate = Carbon::parse($this->viewDate)->subMonth();

        if ($newDate->isBefore(Carbon::tomorrow()->startofMonth())) {
            return;
        }

        $this->viewDate = $newDate->format('Y-m-d');
    }

    public function selectService(int $id): void
    {
        $this->selectedServiceId = $id;
        $this->selectedTime = null;
    }

    public function selectEmployee(int $id): void
    {
        $this->selectedEmployeeId = $id;
        $this->selectedTime = null;
    }

    public function selectDate(string $date): void
    {
        $this->selectedDate = $date;
        $this->selectedTime = null;
    }

    public function selectTime(string $time): void
    {
        $this->selectedTime = $time;
    }

    /**
     * Computed Property: This is the logic for your "AvailableSlots".
     * Using the #[Computed] attribute allows you to access this
     * in your Blade file as $this->availableSlots
     */
    #[Computed]
    public function availableSlots(): array
    {
        if (!$this->selectedEmployeeId || !$this->selectedDate || !$this->selectedServiceId) {
            return [];
        }

        $service = $this->services->find($this->selectedServiceId);
        $duration = $service->duration;

        $date = Carbon::parse($this->selectedDate);
        $dayOfWeek = $date->dayOfWeek;

        $workDay = Schedule::where('user_id', $this->selectedEmployeeId)
            ->where('day_of_week', $dayOfWeek)
            ->first();

        if (!$workDay) return [];

        // Fetch all bookings for this employee on this day
        $existingBookings = Appointment::where('employee_id', $this->selectedEmployeeId)
            ->whereDate('start_time', $this->selectedDate)
            ->get();

        $slots = [];
        $start = Carbon::parse($workDay->start_time);
        $end = Carbon::parse($workDay->end_time);

        while ($start < $end) {
            $potentialStart = Carbon::parse($this->selectedDate . ' ' . $start->format('H:i:s'));
            $potentialEnd = (clone $potentialStart)->addMinutes($duration);

            // 1. Check if the professional is already busy during THIS specific range
            $isOverlapping = $existingBookings->contains(function ($booking) use ($potentialStart, $potentialEnd) {
                $bookingStart = Carbon::parse($booking->start_time);
                $bookingEnd = Carbon::parse($booking->end_time);

                // Standard Range Overlap Formula
                return $potentialStart->lt($bookingEnd) && $potentialEnd->gt($bookingStart);
            });

            // 2. Ensure the service doesn't end AFTER the professional goes home
            $isWithinShift = $potentialEnd <= Carbon::parse($this->selectedDate . ' ' . $workDay->end_time);

            $slots[] = [
                'time' => $start->format('h:i A'),
                'raw' => $start->format('H:i:s'),
                'available' => !$isOverlapping && $isWithinShift
            ];

            $start->addMinutes(30); // We still show slots every 30 mins
        }

        return $slots;
    }

    public function confirmAppointment()
    {
        try {
            if (!Auth::check()) {
                return redirect()->route('login');
            }

            $this->validate([
                'selectedServiceId' => 'required|exists:services,id',
                'selectedEmployeeId' => 'required|exists:users,id',
                'selectedDate' => 'required|date',
                'selectedTime' => 'required'
            ]);

            $service = Service::find($this->selectedServiceId);
            $start = Carbon::parse($this->selectedDate . ' ' . $this->selectedTime);
            $end = (clone $start)->addMinutes($service->duration);

            Appointment::create([
                'user_id' => Auth::id(),
                'service_id' => $this->selectedServiceId,
                'employee_id' => $this->selectedEmployeeId,
                'start_time' => $start,
                'end_time' => $end,
                'status' => Appointment::STATUS_CONFIRMED
            ]);

            $this->showSuccess = true;

        } catch (ValidationException $e) {
            throw $e;
        } catch (\Exception $exception) {
            logger($exception->getMessage());
            $this->dispatch('notify', ['message' => 'Something went wrong']); // Added missing semicolon
        }

        Auth::user()->notify(new AppNotification(
            'success',
            'Booking Confirmed: ',
            'Your ' . $service->name . ' with '
            . User::find($this->selectedEmployeeId)->name
            . ' on ' . Carbon::parse($this->selectedDate)->format('F j, Y')
            . ' at ' . Carbon::parse($this->selectedTime)->format('h:i A')
            . ' has been confirmed.'
        ));
    }

    public function render(): View
    {
        return view('livewire.pages.landing.customer-booking', [
            'slots' => $this->availableSlots
        ]);
    }
}
