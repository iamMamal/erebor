<?php

namespace App\Livewire\Dashboard\Admin;

use Livewire\Component;

class EditUser extends Component
{
    public $accountId;
    public $name;
    public $mobile;
    public $address;

    public function mount($id)
    {
        $this->accountId = $id;
        $account = \App\Models\User::find($id);

        $this->name = $account->name;
        $this->mobile = $account->mobile;
        $this->address = $account->address;


    }

    public function update()
    {
        $this->validate([
            'name' => 'required|string|min:2|max:255',
            'mobile' => 'required|string|min:2|max:11',
        ]);

        \App\Models\User::
            find($this->accountId)
            ->update([
                'name' => $this->name,
                'mobile' => $this->mobile,
                'address' => $this->address,
            ]);

        session()->flash('success', 'حساب با موفقیت ویرایش شد');
        return redirect('/dashboard/user-manager');
    }

    public function render()
    {
        return view('livewire.dashboard.admin.edit-user')->layout('components.layouts.admin');
    }
}
