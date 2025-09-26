<?php

namespace App\Livewire\Dashboard\Ai;
use App\Models\Account;
use App\Models\Transaction;

class EliBotCommandHandler
{
    public function handle(array $command, $userId)
    {
        if ($command['action'] === 'create_transaction') {
            $account = Account::where('user_id', $userId)
                ->where('name', $command['title'])
                ->first();

            if (!$account) {
                return "حساب {$command['title']} پیدا نشد.";
            }

            $transaction = Transaction::create([
                'account_id' => $account->id,
                'user_id' => auth()->id,
                'category_id' => 3, // deposit or withdraw
                'amount' => $command['amount'],
                'description' => 'ثبت شده توسط EliBot',
                'transaction_date' => now(),
            ]);

            return "تراکنش {$command['amount']} تومنی برای حساب {$command['title']} ثبت شد.";
        }

        return null; // No command
    }
}
