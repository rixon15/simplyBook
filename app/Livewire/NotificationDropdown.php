<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class NotificationDropdown extends Component
{
    public function markAllAsRead()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if ($user) {
            $user->unreadNotifications->markAsRead();
        }
    }

    public function markAsRead($notificationId)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($user) {
            // Find the specific notification and mark it as read
            $notification = $user->unreadNotifications()->find($notificationId);
            if ($notification) {
                $notification->markAsRead();
            }
        }
    }

    public function render()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        return view('components.notification-dropdown', [
            'notifications' => $user ? $user->unreadNotifications()->take(5)->get() : collect()
        ]);
    }
}
