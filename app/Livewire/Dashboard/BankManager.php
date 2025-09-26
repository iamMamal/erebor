<?php

namespace App\Livewire\Dashboard;

use App\Models\Account;
use Livewire\Component;

class BankManager extends Component
{
    public  $count = 0;
    public  $totalBalance = 0;
    public  $lastAccount =null;
    public $accounts;

    public $delete_id;
    protected $listeners = ['deleteConfirmed'=>'deleteAccount'];



    public function mount()
    {
        $this->loadData();
    }

    public function loadData()
    {
        $this->count = auth()->user()->accounts()->count();
        $this->totalBalance = auth()->user()->accounts()->sum('balance');
        $this->lastAccount  = Account::where('user_id', auth()->id())->latest()->first();
        $this->accounts = Account::where('user_id', auth()->id())->get();
    }

    public function deleteConfirmation($id)
    {

        $this->delete_id = $id;
        $this->dispatch('show-delete-confirmation');
    }

    public function deleteAccount()
    {
        $account= Account::where('id',$this->delete_id)->first();
        $account->delete();
        $this->loadData();
        $this->dispatch('studentDeleted');
    }



    public function render()
    {
        return view('livewire.dashboard.bank-manager')->layout('components.layouts.admin');
    }
}
