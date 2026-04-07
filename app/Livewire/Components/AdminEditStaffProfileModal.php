<?php

namespace App\Livewire\Components;

use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class AdminEditStaffProfileModal extends Component
{
    use WithFileUploads;

    public bool $showModal = false;
    public ?int $staffId = null;

    public string $name = '';
    public string $email = '';
    public string $title = '';
    public string $phone = '';
    public $photo; // For new upload
    public ?string $existingPhotoUrl = null;

    #[On('open-edit-profile-modal')]
    public function loadStaff($id)
    {
        $staff = User::findOrFail($id);
        $this->staffId = $id;
        $this->name = $staff->name;
        $this->email = $staff->email;
        $this->title = $staff->title ?? '';
        $this->phone = $staff->phone ?? '';
        $this->existingPhotoUrl = $staff->profile_photo_url;
        $this->photo = null;

        $this->showModal = true;
    }

    public function update()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->staffId,
            'title' => 'required|string|max:100',
            'phone' => 'nullable|string',
            'photo' => 'nullable|image|max:1024',
        ]);

        $staff = User::findOrFail($this->staffId);
        $updateData = [
            'name' => $this->name,
            'email' => $this->email,
            'title' => $this->title,
            'phone' => $this->phone,
        ];

        if ($this->photo) {
            // Delete old photo if it exists
            if ($staff->profile_photo_path) {
                Storage::disk('public')->delete($staff->profile_photo_path);
            }
            $updateData['profile_photo_path'] = $this->photo->store('profile-photos', 'public');
        }

        $staff->update($updateData);

        $this->showModal = false;
        $this->dispatch('refresh-staff');
        $this->dispatch('notify', ['message' => 'Profile updated successfully!', 'type' => 'success']);
    }

    public function render()
    {
        return view('livewire.components.admin-edit-staff-profile-modal');
    }
}
