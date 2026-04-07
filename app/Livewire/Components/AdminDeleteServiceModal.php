<?php

namespace App\Livewire\Components;

use App\Models\Service;
use Livewire\Attributes\On;
use Livewire\Component;

class AdminDeleteServiceModal extends Component
{
    public bool $showModal = false;
    public ?int $serviceId = null;
    public string $serviceName = '';

    #[On('confirm-service-deletion')]
    public function load($id)
    {
        $service = Service::findOrFail($id);
        $this->serviceId = $id;
        $this->serviceName = $service->name;
        $this->showModal = true;
    }

    public function delete()
    {
        Service::findOrFail($this->serviceId)->delete();
        $this->showModal = false;
        $this->dispatch('refresh-services');
        $this->dispatch('notify', ['message' => 'Service permanently removed.', 'type' => 'success']);
    }

    public function render() { return view('livewire.components.admin-delete-service-modal'); }
}
