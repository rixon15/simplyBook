<?php

namespace App\Livewire\Pages\Admin;

use App\Models\Service;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.dashboard')]
class Services extends Component
{
    use WithPagination;

    // Toggle the active status of a service directly from the table/card
    public function toggleStatus($id)
    {
        $service = Service::findOrFail($id);
        $service->is_active = !$service->is_active;
        $service->save();

        $this->dispatch('notify', [
            'message' => $service->name . ' is now ' . ($service->is_active ? 'Active' : 'Inactive'),
            'type' => 'success'
        ]);
    }

    // Placeholder for when we build the delete confirmation modal
    public function confirmDelete($id)
    {
        $this->dispatch('notify', [
            'message' => 'Delete modal will go here!',
            'type' => 'info'
        ]);
    }

    public function render()
    {
        return view('livewire.pages.admin.services', [
            // Adjust the pagination number as needed
            'services' => Service::orderBy('name')->paginate(10)
        ]);
    }
}
