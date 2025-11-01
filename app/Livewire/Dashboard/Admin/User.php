<?php

namespace App\Livewire\Dashboard\Admin;

use Livewire\Component;

class User extends Component
{
    public $search = '';
    public $users ;
    public $status = [];
    public $delete_id;
    protected $listeners = ['deleteConfirmed'=>'deleteAccount'];

    public function mount() {

        $this->load();
    }

    public function load()
    {
        $this->searchByMobile();

    }

    public function updatedSearch()
    {
        $this->load();
    }
    public function updateStatus($userId)
    {
        $user = \App\Models\User::find($userId);
        if ($user) {
            $user->is_blocked = (bool)$this->status[$userId];
            $user->save();

        }
        $this->load();

    }

    public function deleteConfirmation($id)
    {

        $this->delete_id = $id;
        $this->dispatch('show-delete-confirmation');
    }

    public function deleteAccount()
    {
        $account= \App\Models\User::where('id',$this->delete_id)->first();
        $account->delete();
        $this->load();
        $this->dispatch('studentDeleted');
    }

    public function searchByMobile()
    {
        if ($this->search) {
            $this->users = \App\Models\User::query()
                ->where('mobile', 'like', '%' . $this->search . '%')
                ->get();
        } else {
            $this->users = \App\Models\User::all();
        }
    }
    public function render()
    {
        return view('livewire.dashboard.admin.user')->layout('components.layouts.admin');
    }
}
