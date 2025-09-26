<?php

namespace App\Livewire\Dashboard\Debt;

use App\Models\Debt;
use App\Models\Installment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AddInstallment extends Component
{
    public $debts;
//برای فرم
    public $balance ='';
    public $careerDate , $debtChose ,$period,$count;

    public function mount()
    {
        // گرفتن debts
        $this->debts = Debt::where('user_id', Auth::id())->get();
    }

        protected $rules = [
        'balance' => 'required|numeric|min:0',
        'debtChose' => 'required',
        'period' => 'required|integer|min:1|max:120',
        'count' => 'required|integer|min:1|max:24',
        'careerDate' => 'required',
    ];




    public function save()
    {


// اضافه کردن روزها (مثلاً 10 روز)

        $this->validate();
        $startDate = Carbon::createFromTimestamp($this->careerDate); // مثلاً 2025-08-27
        $time = date('Y-m-d', $this->careerDate);

        $count = (int)$this->count;
        for ($i = 0; $i < $count; $i++) {
            $newDate = (clone $startDate)->addDays((int)$this->period * $i)->format('Y-m-d');

            Installment::create([
                'debt_id' => $this->debtChose,
                'amount' => $this->balance,
                'due_date' => $newDate,
            ]);
        }

        session()->flash('success', 'اقساط با موفقیت ثبت شد ✅');

        return redirect('/dashboard/debt-manager');
    }

    public function render()
    {
        return view('livewire.dashboard.debt.add-installment')->layout('components.layouts.admin');
    }
}
