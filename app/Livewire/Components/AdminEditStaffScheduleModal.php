<?php

namespace App\Livewire\Components;

use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Component;

class AdminEditStaffScheduleModal extends Component
{
    public bool $showModal = false;
    public ?int $staffId = null;
    public string $staffName = '';

    // Form Fields
    public array $selectedDays = [];
    public string $shiftStart = '';
    public string $shiftEnd = '';
    public string $status = '';

    #[On('open-edit-schedule-modal')]
    public function loadStaff($id)
    {
        $staff = User::findOrFail($id);
        $this->staffId = $id;
        $this->staffName = $staff->name;
        $this->status = $staff->status ?? 'active';

        // Parse working hours (e.g., "09:00 - 17:00")
        if ($staff->working_hours) {
            $parts = explode(' - ', $staff->working_hours);
            $this->shiftStart = $parts[0] ?? '09:00';
            $this->shiftEnd = $parts[1] ?? '17:00';
        } else {
            $this->shiftStart = '09:00';
            $this->shiftEnd = '17:00';
        }

        // Initialize the Day Boolean Map (Defaulting to Mon-Fri if empty)
        $this->selectedDays = [
            0 => false, 1 => false, 2 => false, 3 => false, 4 => false, 5 => false, 6 => false
        ];

        if ($staff->working_days) {
            $map = ['Mon' => 0, 'Tue' => 1, 'Wed' => 2, 'Thu' => 3, 'Fri' => 4, 'Sat' => 5, 'Sun' => 6];
            foreach (explode(', ', $staff->working_days) as $dayName) {
                if (isset($map[$dayName])) {
                    $this->selectedDays[$map[$dayName]] = true;
                }
            }
            // Handle "Mon - Fri" shorthand
            if ($staff->working_days === "Mon - Fri") {
                for ($i = 0; $i <= 4; $i++) $this->selectedDays[$i] = true;
            }
        }

        $this->showModal = true;
    }

    protected function formatWorkingDays(): string
    {
        $map = [0 => 'Mon', 1 => 'Tue', 2 => 'Wed', 3 => 'Thu', 4 => 'Fri', 5 => 'Sat', 6 => 'Sun'];
        $activeKeys = collect($this->selectedDays)->filter(fn($v) => $v)->keys()->sort();
        $days = $activeKeys->map(fn($k) => $map[$k]);

        if ($days->count() === 5 && $activeKeys->first() === 0 && $activeKeys->last() === 4) {
            return "Mon - Fri";
        }
        return $days->implode(', ');
    }

    public function save()
    {
        $this->validate([
            'status' => 'required|in:active,leave,off',
            'shiftStart' => 'required',
            'shiftEnd' => 'required|after:shiftStart',
        ]);

        $staff = User::findOrFail($this->staffId);
        $staff->update([
            'status' => $this->status,
            'working_days' => $this->formatWorkingDays(),
            'working_hours' => $this->shiftStart . ' - ' . $this->shiftEnd,
        ]);

        $this->showModal = false;
        $this->dispatch('refresh-staff');
        $this->dispatch('notify', ['message' => 'Schedule updated for ' . $this->staffName, 'type' => 'success']);
    }

    public function render() { return view('livewire.components.admin-edit-staff-schedule-modal'); }
}
