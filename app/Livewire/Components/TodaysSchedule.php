<?php

namespace App\Livewire\Components;

use App\Enums\AppointmentStatus;
use App\Models\Appointment;
use Livewire\Attributes\On;
use Livewire\Component;

class TodaysSchedule extends Component
{

    public function getAppointements()
    {



        return Appointment::whereDate('start_time', today())
            ->with(['user', 'employee', 'service'])
            ->orderBy('start_time')
            ->take(4)->get()->map(function ($appointment) {
                return [
                    'id' => $appointment->id,
                    'time' => $appointment->start_time->format('h:i A'),
                    'customer' => $appointment->user->name,
                    'staff' => $appointment->employee->name,
                    'service' => $appointment->service->name,
                    'status' => ucfirst($appointment->status->value),
                    'status_color' => match($appointment->status) {
                        AppointmentStatus::PENDING   => 'pending',
                        AppointmentStatus::CONFIRMED => 'confirmed',
                        AppointmentStatus::COMPLETED => 'completed',
                        AppointmentStatus::CANCELED  => 'canceled',
                        AppointmentStatus::NO_SHOW   => 'noshow',
                    },
                    'indicator_color' => match ($appointment->status) {
                        AppointmentStatus::CONFIRMED => 'bg-[#4a40e0]',
                        AppointmentStatus::COMPLETED => 'bg-emerald-500',
                        AppointmentStatus::PENDING   => 'bg-amber-500',
                        AppointmentStatus::CANCELED  => 'bg-rose-500',
                        AppointmentStatus::NO_SHOW   => 'bg-slate-400',
                        default => 'bg-slate-300',
                    },
                ];
            });
    }


    public function updateStatus($appointmentId, $newStatus): void
    {
        $appointment = Appointment::findOrFail($appointmentId);

        if ($appointment->status === AppointmentStatus::COMPLETED) {
            $this->dispatch('notify', [
                'message' => "Locked: Completed appointments cannot be modified.",
                'type' => 'error',
            ]);
            return;
        }

        $statusEnum = $newStatus instanceof AppointmentStatus
            ? $newStatus
            : AppointmentStatus::from($newStatus);

        $appointment->update(['status' => $statusEnum]);

        $this->dispatch('notify', [
            'message' => "Appointment is now " . ucfirst($statusEnum->value),
            'type' => 'success',
        ]);
    }

    #[On('refresh-schedule')]
    public function refresh() {}
    public function render()
    {

        $appointments = $this->getAppointements();

        return view('livewire.components.todays-schedule', compact('appointments'));

    }
}
