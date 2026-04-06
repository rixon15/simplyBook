<?php

namespace App\Livewire\Pages\Admin;

use App\Enums\AppointmentStatus;
use App\Models\Appointment;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;

#[Layout('layouts.dashboard')]
class Appointments extends Component
{
    public string $selectedDate;
    public string $viewType = 'day';

    public bool $showDoneModal = false;
    public ?Appointment $selectedAppointment = null;

    public ?int $selectedMobileStaffId = null;

    public function mount()
    {
        $this->selectedDate = Carbon::today()->format('Y-m-d');

        $this->selectedMobileStaffId = User::where('role', 'employee')->first()?->id;
    }

    /**
     * Calculates overlap columns for a specific day's appointments.
     */
    public function getOverlapLayout($dayAppointments)
    {
        $positions = [];
        $columns = []; // Keeps track of the end time of the last appointment in each column

        // Sort chronologically
        $sorted = $dayAppointments->sortBy('start_time')->values();

        foreach ($sorted as $appt) {
            $placed = false;

            // Try to fit the appointment into an existing column
            foreach ($columns as $colIndex => $columnEndTime) {
                if (Carbon::parse($appt->start_time)->gte(Carbon::parse($columnEndTime))) {
                    $columns[$colIndex] = $appt->end_time;
                    $positions[$appt->id] = $colIndex;
                    $placed = true;
                    break;
                }
            }

            // If it overlaps with ALL existing columns, create a new column
            if (!$placed) {
                $columns[] = $appt->end_time;
                $positions[$appt->id] = count($columns) - 1;
            }
        }

        // Divide 100% width by the maximum number of simultaneous overlaps that day
        $totalCols = max(1, count($columns));

        return [
            'positions' => $positions,
            'width' => 100 / $totalCols
        ];
    }

    public function goToToday()
    {
        $this->selectedDate = Carbon::today()->format('Y-m-d');
    }

    public function nextDay()
    {
        $date = Carbon::parse($this->selectedDate);
        $this->selectedDate = $this->viewType === 'day'
            ? $date->addDay()->format('Y-m-d')
            : $date->addWeek()->format('Y-m-d');
    }

    public function prevDay()
    {
        $date = Carbon::parse($this->selectedDate);
        $this->selectedDate = $this->viewType === 'day'
            ? $date->subDay()->format('Y-m-d')
            : $date->subWeek()->format('Y-m-d');
    }

    public function setView($type)
    {
        $this->viewType = $type;
    }

    #[Computed]
    public function dateLabel()
    {
        $date = Carbon::parse($this->selectedDate);
        if ($date->isToday()) return 'Today';
        if ($date->isYesterday()) return 'Yesterday';
        if ($date->isTomorrow()) return 'Tomorrow';
        return $date->format('M j');
    }

    public function selectMobileStaff($id)
    {
        // If they tap the already selected staff, clear it to show ALL staff
        if ($this->selectedMobileStaffId === $id) {
            $this->selectedMobileStaffId = null;
        } else {
            $this->selectedMobileStaffId = $id;
        }
    }

    #[Computed]
    public function employees()
    {
        return User::where('role', 'employee')->get();
    }

    #[Computed]
    public function appointments()
    {
        $query = Appointment::with(['user', 'service', 'employee']);

        if ($this->viewType === 'week') {
            $start = Carbon::parse($this->selectedDate)->startOfWeek();
            $end = Carbon::parse($this->selectedDate)->endOfWeek();
            return $query->whereBetween('start_time', [$start, $end])->get();
        }

        return $query->whereDate('start_time', $this->selectedDate)->get();
    }


    public function getPosition(Appointment $appointment)
    {
        // IMPORTANT FIX: Use the appointment's OWN date to establish 09:00 AM.
        // This ensures blocks map correctly in the Week View across different days.
        $startOfDay = Carbon::parse($appointment->start_time->format('Y-m-d') . ' 09:00:00');
        $diffInMinutes = $startOfDay->diffInMinutes($appointment->start_time, false);

        $top = ($diffInMinutes / 60) * 64;
        $height = ($appointment->start_time->diffInMinutes($appointment->end_time) / 60) * 64;

        return ['top' => $top . 'px', 'height' => $height . 'px'];
    }

    public
    function updateStatus($appointmentId, $newStatus): void
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

    #[
        On('trigger-done-modal')]
    public function confirmDone($id): void
    {
        $this->selectedAppointment = Appointment::with(['user', 'service'])->findOrFail($id);
        $this->showDoneModal = true;
    }

    public function markAsDone(): void
    {
        if (!$this->selectedAppointment) {
            return;
        }

        $this->selectedAppointment->update(['status' => AppointmentStatus::COMPLETED]);

        $this->showDoneModal = false;
        $this->selectedAppointment = null;

        $this->dispatch('notify', ['message' => 'Appointment marked as completed.']);
    }

    public function render()
    {
        return view('livewire.pages.admin.appointments');
    }
}
