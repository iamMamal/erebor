<?php

namespace App\Livewire\Dashboard;

use App\Models\Account;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class EditTransaction extends Component
{

    public $transaction;
    public $categories;
    public $accounts;

    public $transactionId;
    public $transactionAmount;

    //برای فرم
    public $balance ='';
    public $careerDate , $bankChose,$categoryChose ,$description;



    public function mount($id)
    {

        $this->transactionId = $id;
        $transaction = Transaction::where('user_id', auth()->id())->findOrFail($id);


        // گرفتن حساب‌ها
        $this->accounts = Account::where('user_id', Auth::id())->get();

        // فقط دسته‌هایی که type = 1 هستن
        if ($transaction->category_id <= 8)
            {
        $this->categories = Category::where('type', 1)->get();
            }
        else {

        $this->categories = Category::where('type', 0)->get();
    }

        $this->description = $transaction->description;
        $this->transactionAmount = $transaction->amount;
        $this->categoryChose = $transaction->category_id;
        $this->bankChose = $transaction->account_id;

    }


    protected $rules = [
        'balance' => 'required|numeric|min:0',
        'categoryChose' => 'required',
        'bankChose' => 'required',
        'careerDate' => 'required',
    ];

    public function update()
    {
        $transaction = Transaction::where('user_id', auth()->id())
            ->findOrFail($this->transactionId);
        $oldAccount = $transaction->account_id;
        $oldAccount = Account::find($oldAccount);
        $account = Account::find($this->bankChose);



        $time = date('Y-m-d H:i:s', $this->careerDate);
        $this->validate();


        if ($oldAccount->id !== $account->id) {
            // از حساب قبلی کم کن
            if ($this->categoryChose <= 8) {
                $oldAccount->balance -= $transaction->amount;
                if ($oldAccount->balance < 0) {
                    session()->flash('success1', 'مبلغ وارد شده از کل موجودی حساب بیشتر است');
                    return redirect('/dashboard/bank-manager');
                }
                $oldAccount->save();
                // به حساب جدید اضافه کن
                $account->balance += $this->balance;
                $account->save();
            }
            else{
                $oldAccount->balance += $transaction->amount;
                // به حساب جدید اضافه کن
                $account->balance -= $this->balance;
                if ($account->balance < 0) {
                    session()->flash('success1', 'مبلغ وارد شده از کل موجودی حساب بیشتر است');
                    return redirect('/dashboard/bank-manager');
                }
                $oldAccount->save();
                $account->save();
            }

        } else {
            //varizi
            if ($this->categoryChose <= 8)
            {
                $account->balance = $account->balance - $this->transactionAmount + $this->balance;
            }
            else{
                //bardasht
                $account->balance = $account->balance + $this->transactionAmount - $this->balance;
                if ($account->balance < 0) {
                    session()->flash('success1', 'مبلغ وارد شده از کل موجودی حساب بیشتر است');
                    return redirect('/dashboard/bank-manager');
                }
            }
            $account->save();
        }

        $transaction->update([
                'account_id' => $this->bankChose,
                'amount' => $this->balance,
                'category_id' => $this->categoryChose,
                'transaction_date' => $time,
                'description' => $this->description,
            ]);


        session()->flash('success', 'تراکنش با موفقیت ویرایش شد');
        return redirect('/dashboard/bank-manager');
    }


    public function render()
    {
        return view('livewire.dashboard.edit-transaction')->layout('components.layouts.admin');
    }
}
