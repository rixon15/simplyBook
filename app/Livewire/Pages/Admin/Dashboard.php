<?php

namespace App\Livewire\Pages\Admin;

use App\Enums\AppointmentStatus;
use App\Models\Appointment;
use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;

#[Layout('layouts.dashboard')]
class Dashboard extends Component
{

    public bool $showDoneModal = false;
    public ?Appointment $selectedAppointment = null;

    public function getRevenueToday()
    {
        return Appointment::whereDate('start_time', today())
            ->where('status', 'confirmed')
            ->join('services', 'appointments.service_id', '=', 'services.id')
            ->sum('services.price');
    }

    public function getRevenueYesterday()
    {
        return Appointment::whereDate('start_time', yesterday())
            ->where('status', 'confirmed')
            ->join('services', 'appointments.service_id', '=', 'services.id')
            ->sum('services.price');
    }

    public function getAppointmentCount()
    {
        return Appointment::whereDate('start_time', today())->count();
    }

    public function getPendingCount()
    {
        return Appointment::whereDate('start_time', today())->where('status', 'pending')->count();
    }

    public function getNewCostumers()
    {
        return User::where('role', 'customer')->whereDate('created_at', today()->minus(0, 0, 1))->count();
    }

    public function getActiveStaff()
    {
        return Appointment::whereDate('start_time', today())->distinct('employee_id')->count();
    }

    public function getTotalStaff()
    {
        return User::where('role', 'employee')->count();
    }

    #[On('trigger-done-modal')]
    public function confirmDone($id): void
    {
        $this->selectedAppointment = Appointment::with(['user', 'service'])->findOrFail($id);
        $this->showDoneModal = true;

    }

    public function markAsDone(): void
    {

        if (!$this->selectedAppointment || $this->selectedAppointment->isFinalized()) {
            return;
        }

        $this->selectedAppointment->update(['status' => AppointmentStatus::COMPLETED]);

        $this->showDoneModal = false;
        $this->selectedAppointment = null;

        $this->dispatch('refresh-schedule');
        $this->dispatch('notify', ['message' => 'Appointment marked as completed.']);

    }

    public function render()
    {
        return view('livewire.pages.admin.dashboard', [
            'revenue' => number_format($this->getRevenueToday(), 2),
            'appointmentsCount' => $this->getAppointmentCount(),
            'todayPending' => $this->getPendingCount(),
            'newCustomers' => $this->getNewCostumers(),
            'staffStats' => $this->getActiveStaff() / $this->getTotalStaff(),
            'totalPending' => $this->getTotalStaff(),
        ]);
    }
}
