<?php

namespace App\Livewire\Components;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class AdminCreateStaffModal extends Component
{
    use WithFileUploads;

    public bool $showModal = false;

    // Form Fields
    public string $name = '';
    public string $email = '';
    public string $title = '';
    public string $phone = '';
    public string $status = 'active';
    public string $shiftStart = '09:00';
    public string $shiftEnd = '17:00';

    public array $selectedDays = [
        0 => true, 1 => true, 2 => true, 3 => true, 4 => true, 5 => false, 6 => false
    ];
    public $photo; // For file upload

    #[On('open-create-staff-modal')]
    public function openModal()
    {
        $this->reset(['name', 'email', 'title', 'phone', 'photo', 'shiftStart', 'shiftEnd']);
        // Reset days to default Mon-Fri
        $this->selectedDays = [
            0 => true, 1 => true, 2 => true, 3 => true, 4 => true, 5 => false, 6 => false
        ];
        $this->showModal = true;
    }

    protected function formatWorkingDays(): string
    {
        $map = [0 => 'Mon', 1 => 'Tue', 2 => 'Wed', 3 => 'Thu', 4 => 'Fri', 5 => 'Sat', 6 => 'Sun'];

        // 1. Get only the keys where the value is TRUE
        $activeKeys = collect($this->selectedDays)
            ->filter(fn($val) => $val === true)
            ->keys()
            ->sort();

        // 2. Map the keys to names
        $days = $activeKeys->map(fn($key) => $map[$key]);

        if ($days->count() === 0) return 'No days set';

        // 3. Check for standard Mon-Fri (Keys 0 through 4)
        if ($days->count() === 5 && $activeKeys->first() === 0 && $activeKeys->last() === 4) {
            return "Mon - Fri";
        }

        return $days->implode(', ');
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'title' => 'required|string|max:100',
            'phone' => 'nullable|string',
            'status' => 'required|in:active,leave,off',
            'photo' => 'nullable|image|max:1024', // 1MB Max
            'selectedDays' => 'required|array|min:1',
            'shiftStart' => 'required',
            'shiftEnd' => 'required|after:shiftStart',
        ]);

        $userData = [
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make(Str::random(12)),
            'role' => 'employee',
            'title' => $this->title,
            'phone' => $this->phone,
            'status' => $this->status,
            'working_days' => $this->formatWorkingDays(),
            'working_hours' => $this->shiftStart . ' - ' . $this->shiftEnd,
        ];

        if ($this->photo) {
            $userData['profile_photo_path'] = $this->photo->store('profile-photos', 'public');
        }

        User::create($userData);

        $this->showModal = false;
        $this->dispatch('refresh-staff');
        $this->dispatch('notify', ['message' => 'New team member added!', 'type' => 'success']);
    }

    public function render()
    {
        return view('livewire.components.admin-create-staff-modal');
    }
}
