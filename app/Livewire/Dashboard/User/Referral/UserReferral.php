<?php

namespace App\Livewire\Dashboard\User\Referral;

use Livewire\Component;
use App\Models\ReferralMessage;

class UserReferral extends Component
{
    public $title;
    public $message;
    public $link;

    public function mount()
    {
        $data = ReferralMessage::first();
        if ($data) {
            $this->title = $data->title;
            $this->message = $data->message;
            $this->link = $data->link;
        }
    }

    public function render()
    {
        return view('livewire.dashboard.user.referral.user-referral')
            ->layout('components.layouts.admin'); // طبق الگو
    }
}
