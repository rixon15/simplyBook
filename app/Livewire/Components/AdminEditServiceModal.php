<?php

namespace App\Livewire\Components;

use App\Models\Service;
use Livewire\Attributes\On;
use Livewire\Component;

class AdminEditServiceModal extends Component
{
    public bool $showModal = false;
    public ?int $serviceId = null;

    public string $name = '';
    public string $description = '';
    public ?int $duration = null;
    public ?float $price = null;
    public bool $isActive = true;

    #[On('open-edit-service-modal')]
    public function loadService($id)
    {
        $service = Service::findOrFail($id);
        $this->serviceId = $id;
        $this->name = $service->name;
        $this->description = $service->description ?? '';
        $this->duration = $service->duration;
        $this->price = $service->price;
        $this->isActive = $service->is_active;

        $this->showModal = true;
    }

    public function update()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'duration' => 'required|integer|min:5',
            'price' => 'required|numeric|min:0',
        ]);

        $service = Service::findOrFail($this->serviceId);
        $service->update([
            'name' => $this->name,
            'description' => $this->description,
            'duration' => $this->duration,
            'price' => $this->price,
            'is_active' => $this->isActive,
        ]);

        $this->showModal = false;
        $this->dispatch('refresh-services');
        $this->dispatch('notify', ['message' => 'Service updated successfully!']);
    }

    public function render()
    {
        return view('livewire.components.admin-edit-service-modal');
    }
}
