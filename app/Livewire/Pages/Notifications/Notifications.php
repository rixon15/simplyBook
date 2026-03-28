<?php

namespace App\Livewire\Pages\Notifications;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Component;

class Notifications extends Component
{

    public function markAllAsRead(): void
    {
        $user = Auth::user();

        if ($user) {
            $user->unreadNotifications->markAsRead();
        }
    }

    public function markAsRead($notificationId): void
    {
        $user = Auth::user();

        if ($user) {
            $user->unreadNotifications()->find($notificationId)?->markAsRead();
        }
    }


    public function render(): View
    {
        $user = Auth::user();

        $layout = (auth()->user()->role === 'admin' || auth()->user()->role === 'employee')
            ? 'layouts.dashboard'
            : 'layouts.app';

        if (!$user) {
            return view('livewire.pages.notifications.notifications', [
                'groupedNotifications' => collect(),
                'isEmpty' => true,
                'unreadCount' => 0
            ]);
        }

        $allNotifications = $user->notifications()->get();

        $grouped = $allNotifications->groupBy(function ($notification) {
            if ($notification->created_at->isToday()) return 'Today';
            if ($notification->created_at->isYesterday()) return 'Yesterday';
            return 'Older';
        });

        return view('livewire.pages.notifications.notifications', [
            'groupedNotifications' => $grouped,
            'isEmpty' => $allNotifications->isEmpty(),
            'unreadCount' => $user->unreadNotifications()->count()
        ])->layout($layout);
    }
}
