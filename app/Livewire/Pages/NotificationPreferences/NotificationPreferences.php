<?php

namespace App\Livewire\Pages\NotificationPreferences;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class NotificationPreferences extends Component
{

    public bool $emailNotifications = true;
    public bool $smsNotifications = false;

    public function mount()
    {
        $user = Auth::user();

        $this->emailNotifications = $user->email_notifications;
        $this->smsNotifications = $user->sms_notifications;
    }

    public function render()
    {
        return view('livewire.pages.notification-preferences.notification-preferences')->layout('layouts.dashboard');
    }

    public function savePreferences(): void
    {
        $user = Auth::user();

        $user->update([
            'email_notifications' => $this->emailNotifications,
            'sms_notifications' => $this->smsNotifications,
        ]);
    }
}
