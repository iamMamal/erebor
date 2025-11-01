<?php

namespace App\Livewire\Dashboard\Admin\UserPoints;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use App\Models\UserPoint;

class UserPointsManager extends Component
{
    use WithPagination;

    public $showModal = false;

    public $search = '';
    public $selectedUser = null;
    public $points;
    public $reason;

    public function render()
    {
        $users = User::where('name', 'like', "%{$this->search}%")
            ->orWhere('mobile', 'like', "%{$this->search}%")
            ->paginate(10);

        return view('livewire.dashboard.admin.user-points.user-points-manager', [
            'users' => $users,
        ])->layout('components.layouts.admin');
    }
    public function selectUser($userId)
    {
        $this->selectedUser = User::findOrFail($userId);
        $this->reset(['points', 'reason']);
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->reset(['selectedUser', 'points', 'reason']);
    }


    public function addPoints()
    {
        $this->validate([
            'points' => 'required|integer',
            'reason' => 'nullable|string|max:255',
        ]);

        UserPoint::create([
            'user_id' => $this->selectedUser->id,
            'points' => $this->points,
            'reason' => $this->reason,
        ]);

        $this->reset(['points', 'reason']);
        $this->dispatch('pointsAdded');
    }

    public function deletePoint($id)
    {
        UserPoint::findOrFail($id)->delete();
        $this->dispatch('pointDeleted');
    }

    public function getUserPointsProperty()
    {
        return $this->selectedUser
            ? $this->selectedUser->pointsHistory()->latest()->get()
            : collect();
    }
}
