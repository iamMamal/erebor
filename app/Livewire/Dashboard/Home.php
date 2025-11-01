<?php

namespace App\Livewire\Dashboard;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Morilog\Jalali\Jalalian;

class Home extends Component
{
    public $user ;
    public function mount()
    {
        $user = Auth::user();

    }

    public function render()
    {

        return view('livewire.dashboard.home')->layout('components.layouts.admin');
    }
}
