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

    public function mount()
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone = $user->phone ?? '';
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

    public function render()
    {
        $layout = (auth()->user()->role === 'admin' || auth()->user()->role === 'employee')
            ? 'layouts.dashboard'
            : 'layouts.app';

        return view('livewire.pages.profile.user-profile')
            ->layout($layout);

    }
}
