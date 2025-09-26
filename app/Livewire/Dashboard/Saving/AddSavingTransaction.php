<?php

namespace App\Livewire\Dashboard\Saving;

use App\Models\Saving;
use App\Models\SavingTransaction;
use App\Models\Transaction;
use Livewire\Component;

class AddSavingTransaction extends Component
{
    public $selectedOption = null;
    public $balance = '';
    public $careerDate, $description, $type;



    public function selectOption($option)
    {
        $this->selectedOption = $option;

    }

    protected $rules = [
        'balance' => 'required|numeric|min:0',
        'type' => 'required',
    ];

    public function save()
    {
        $this->validate();
        $saving = Saving::where('user_id', auth()->id())->first();

        if ($saving) {
            if ($this->type==0) {
                if ($saving->amount < $this->balance) {
                    session()->flash('success1', 'مبلغ وارد شده از کل موجودی حساب بیشتر است');
                    return redirect('/dashboard/saving-manager');
                } else {
                    $saving->amount -= $this->balance; // یا -= برای برداشت
                    $saving->save();
                }
            }
          else{
                    $saving->amount += $this->balance; // یا -= برای برداشت
                    $saving->save();
                }
                SavingTransaction::create([
                    'saving_id' => $saving->id,
                    'amount' => $this->balance,
                    'type' => $this->type,
                    'description' => $this->description,
                ]);
                session()->flash('success', 'تراکنش با موفقیت ثبت شد ✅');
                return redirect('/dashboard/saving-manager');
            }

         else {
            return redirect('/dashboard/saving-manager');
        }
    }

    public function render()
    {
        return view('livewire.dashboard.saving.add-saving-transaction')->layout('components.layouts.admin');
    }
}
