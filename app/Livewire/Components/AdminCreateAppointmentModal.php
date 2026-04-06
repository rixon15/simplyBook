<?php

namespace App\Livewire\Components;

use App\Models\Appointment;
use App\Models\Service;
use App\Models\User;
use Carbon\Carbon;
use Hash;
use Livewire\Attributes\On;
use Livewire\Component;
use Str;

class AdminCreateAppointmentModal extends Component
{
    public bool $showModal = false;
    public bool $isGuest = false; // Toggle state

    // Form Fields
    public ?int $userId = null;
    public ?int $serviceId = null;
    public ?int $employeeId = null;
    public $date;
    public $time;

    // Guest Fields
    public string $guestName = '';
    public string $guestEmail = '';

    // Search logic
    public string $userSearch = '';
    public $foundUsers = [];

    // ... mount and openModal methods stay the same ...

    public function save()
    {
        $rules = [
            'serviceId' => 'required|exists:services,id',
            'employeeId' => 'required|exists:users,id',
            'date' => 'required|date',
            'time' => 'required',
        ];

        if ($this->isGuest) {
            $rules['guestName'] = 'required|string|max:255';
            $rules['guestEmail'] = 'required|email|unique:users,email';
        } else {
            $rules['userId'] = 'required|exists:users,id';
        }

        $this->validate($rules);

        // 1. If guest, create the user record first
        if ($this->isGuest) {
            $user = User::create([
                'name' => $this->guestName,
                'email' => $this->guestEmail,
                'password' => Hash::make(Str::random(12)), // Random password for guests
                'role' => 'customer',
            ]);
            $this->userId = $user->id;
        }

        $service = Service::find($this->serviceId);
        $start = Carbon::parse($this->date . ' ' . $this->time);
        $end = (clone $start)->addMinutes($service->duration);

        Appointment::create([
            'user_id' => $this->userId,
            'service_id' => $this->serviceId,
            'employee_id' => $this->employeeId,
            'start_time' => $start,
            'end_time' => $end,
            'status' => 'confirmed',
        ]);

        $this->showModal = false;
        $this->isGuest = false;
        $this->reset(['guestName', 'guestEmail', 'userSearch', 'userId']);

        $this->dispatch('refresh-schedule');
        $this->dispatch('notify', ['message' => 'Appointment created successfully!']);
    }

    public function mount()
    {
        $this->date = Carbon::today()->format('Y-m-d');
        $this->time = '09:00';
    }

    #[On('open-create-appointment-modal')]
    public function openModal()
    {
        $this->reset(['userId', 'serviceId', 'employeeId', 'userSearch', 'foundUsers']);
        $this->date = Carbon::today()->format('Y-m-d');
        $this->showModal = true;
    }

    public function updatedUserSearch()
    {
        if (strlen($this->userSearch) < 2) {
            $this->foundUsers = [];
            return;
        }

        $this->foundUsers = User::where('role', 'customer')
            ->where(function($query) {
                $query->where('name', 'like', '%' . $this->userSearch . '%')
                    ->orWhere('email', 'like', '%' . $this->userSearch . '%');
            })
            ->take(5)
            ->get();
    }

    public function selectUser($id, $name)
    {
        $this->userId = $id;
        $this->userSearch = $name;
        $this->foundUsers = [];
    }

    public function render()
    {
        return view('livewire.components.admin-create-appointment-modal', [
            'services' => Service::all(),
            'employees' => User::where('role', 'employee')->get(),
        ]);
    }
}
