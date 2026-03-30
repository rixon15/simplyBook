<?php

namespace App\Livewire\Components;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class RecentActivityFeed extends Component
{

    public function getRecentActivities()
    {

        $user = Auth::user();

        if (!$user) return collect();

        return $user->notifications()->latest()->take(5)->get()->map(function ($notification) {

            $data = $notification->data;
            $type = $data['type'] ?? 'booking';

            return [
                // If the seeder used 'message', we'll pass that as the 'subject'
                // and use the 'type' to determine the styling.
                'type' => $type,
                'user' => $data['user'] ?? 'System',
                'action' => $data['action'] ?? '',
                'subject' => $data['subject'] ?? ($data['message'] ?? 'Notification'),
                'extra' => $data['extra'] ?? '',
                'time' => $notification->created_at->diffForHumans(null, true, true),

                // Map the colors based on the type stored in the DB
                'icon_bg' => match ($type) {
                    'success' => 'bg-[#9795ff]/20',
                    'error' => 'bg-[#fff1f2]',
                    'warning' => 'bg-[#fffbeb]',
                    default => 'bg-[#ecfdf5]',
                },
                'icon_color' => match ($type) {
                    'success' => 'text-[#4a40e0]',
                    'error' => 'text-[#f43f5e]',
                    'warning' => 'text-[#f59e0b]',
                    default => 'text-[#059669]',
                },
            ];
        });
    }

    public function render()
    {
        $activities = $this->getRecentActivities();

        return view('livewire.components.recent-activity-feed', [
            'activities' => $activities
        ]);
    }
}
