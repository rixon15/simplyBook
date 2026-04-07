<?php

namespace App\Livewire\Components;

use App\Models\Service;
use Livewire\Attributes\On;
use Livewire\Component;

class AdminCreateServiceModal extends Component
{
    public bool $showModal = false;

    // Form Fields
    public string $name = '';
    public string $description = '';
    public ?int $duration = null;
    public ?float $price = null;
    public bool $isActive = true;

    #[On('open-create-service-modal')]
    public function openModal()
    {
        $this->reset(['name', 'description', 'duration', 'price']);
        $this->isActive = true; // Default new services to active
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'duration' => 'required|integer|min:5|max:480', // minutes
            'price' => 'required|numeric|min:0',
            'isActive' => 'boolean',
        ]);

        Service::create([
            'name' => $this->name,
            'description' => $this->description,
            'duration' => $this->duration,
            'price' => $this->price,
            'is_active' => $this->isActive,
        ]);

        $this->showModal = false;

        // Tell the main Services page to reload its data
        $this->dispatch('refresh-services');

        $this->dispatch('notify', [
            'message' => 'Service created successfully!',
            'type' => 'success'
        ]);
    }

    public function render()
    {
        return view('livewire.components.admin-create-service-modal');
    }
}
