<?php

namespace App\Livewire\Components;

use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Component;

class AdminDeleteStaffModal extends Component
{
    public bool $showModal = false;
    public ?int $staffId = null;
    public string $staffName = '';

    #[On('confirm-staff-deletion')]
    public function loadStaff($id)
    {
        $staff = User::findOrFail($id);
        $this->staffId = $id;
        $this->staffName = $staff->name;
        $this->showModal = true;
    }

    public function delete()
    {
        $staff = User::findOrFail($this->staffId);

        // Because the Model uses SoftDeletes, this won't wipe the record
        $staff->delete();

        $this->showModal = false;
        $this->dispatch('refresh-staff');
        $this->dispatch('notify', [
            'message' => $this->staffName . ' has been removed from the active team.',
            'type' => 'success'
        ]);
    }

    public function render()
    {
        return view('livewire.components.admin-delete-staff-modal');
    }
}
