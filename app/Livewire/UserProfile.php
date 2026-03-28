<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Livewire\Component;

class UserProfile extends Component
{

    public string $name = '';
    public string $email = '';
    public string $phone = '';

    public bool $emailNotifications = true;
    public bool $smsNotifications = false;

    public function mount()
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone = $user->phone ?? '';


        $this->emailNotifications = $user->email_notifications;
        $this->smsNotifications = $user->sms_notifications;
    }

    public function saveProfile(): void
    {
        $user = Auth::user();

        if ($user->role === 'employee') {
            $this->dispatch('notify', ['message' => 'Identity fields are managed by administration.', 'type' => 'error']);
            return;
        }

        $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => ['nullable', 'string', 'max:20'],
        ]);

        $user->update([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
        ]);

        $this->dispatch('notify', ['message' => 'Profile updated successfully']);
    }

    public function savePreferences(): void
    {
        $user = Auth::user();

        $user->update([
            'email_notifications' => $this->emailNotifications,
            'sms_notifications' => $this->smsNotifications,
        ]);

        $this->dispatch('notify', ['message' => 'Preferences saved!']);
    }

    public function render()
    {
        $layout = (auth()->user()->role === 'admin' || auth()->user()->role === 'employee')
            ? 'layouts.dashboard'
            : 'layouts.app';

        return view('livewire.pages.profile.user-profile')
            ->layout($layout);

    }
}
