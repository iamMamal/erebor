<?php

namespace App\Livewire\Dashboard\Admin\Referral;

use Livewire\Component;
use App\Models\ReferralMessage;

class AdminReferral extends Component
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

    public function save()
    {
        ReferralMessage::updateOrCreate(
            ['id' => 1],
            [
                'title' => $this->title,
                'message' => $this->message,
                'link' => $this->link,
            ]
        );

        session()->flash('success', 'پیام معرفی با موفقیت ذخیره شد ✅');
    }

    public function render()
    {
        return view('livewire.dashboard.admin.referral.admin-referral')
            ->layout('components.layouts.admin');
    }
}
