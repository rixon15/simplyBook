<?php

namespace App\Livewire\Pages\Admin;

use App\Models\User;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.dashboard')]
class Staff extends Component
{
    use WithPagination;

    public string $search = '';

    #[On('refresh-staff')]
    public function refreshList()
    {
        // This can be empty; calling it forces Livewire to re-render
    }

    // Action placeholders
    public function deleteStaff($id)
    {
        // Logic for deletion
        $this->dispatch('notify', ['message' => 'Staff member removed.', 'type' => 'success']);
    }

    #[Computed]
    public function stats()
    {
        return [
            'total' => User::where('role', 'employee')->count(),
            'active' => User::where('role', 'employee')->where('status', 'active')->count(),
            'leave' => User::where('role', 'employee')->where('status', 'leave')->count(),
            'off' => User::where('role', 'employee')->where('status', 'off')->count(),
        ];
    }

    public function render()
    {
        $staff = User::where('role', 'employee')
            ->where('name', 'like', '%' . $this->search . '%')
            ->paginate(10);

        return view('livewire.pages.admin.staff', [
            'staffMembers' => $staff
        ]);
    }
}
