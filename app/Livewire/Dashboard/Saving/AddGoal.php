<?php

namespace App\Livewire\Dashboard\Saving;

use App\Models\Saving;
use Livewire\Component;

class AddGoal extends Component
{
    public $balance , $title,$careerDate;
    public $savingId;

    protected $rules = [
        'balance' => 'required|numeric|min:0',
        'title' => 'required|min:3',
        'careerDate' => 'required',
    ];

    public function mount()
    {

        $saving = Saving::where('user_id', auth()->id())->first();
//        dd($saving);

        if ($saving) {
            $this->savingId = $saving->id;
            $this->title = $saving->title;
            $this->balance = $saving->target_amount;

        }
    }

    public function save()
    {
        $time = date('Y-m-d H:i:s', $this->careerDate);
        $this->validate();

        $saving = $this->savingId ? Saving::findOrFail($this->savingId) : new Saving();
        $saving->user_id = auth()->id();
        $saving->title = $this->title;
        $saving->target_amount = $this->balance;
        $saving->target_date = $time;
        $saving->save();

        session()->flash('success', 'هدف با موفقیت ثبت شد ✅');

        return redirect('/dashboard/saving-manager');


    }


    public function render()
    {
        return view('livewire.dashboard.saving.add-goal')->layout('components.layouts.admin');
    }
}
