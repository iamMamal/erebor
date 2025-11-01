<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use App\Models\VerificationCode;
use App\Services\SmsService;

class VerifyResetCode extends Component
{
    public $mobile;
    public $code;
    public $seconds = 60;
    public $resendDisabled = true;
    public $errorMessage = null;
    public $successMessage = null; // ✅ اضافه شد

    public function mount()
    {
        $this->mobile = session('forgot_password_mobile');

        if (!$this->mobile) {
            return $this->redirectRoute('forgot-password');
        }

        $this->startCountdown();
    }

    public function startCountdown()
    {
        $this->resendDisabled = true;
        $this->dispatch('start-countdown');
    }

    public function resendCode()
    {
        $record = VerificationCode::where('mobile', $this->mobile)->latest()->first();

        if ($record && $record->locked_until && now()->lessThan($record->locked_until)) {
            $seconds = now()->diffInSeconds($record->locked_until);
            $minutes = ceil($seconds / 60);
            $this->addError('code', "به دلیل تلاش‌های زیاد، تا {$minutes} دقیقه امکان ارسال مجدد کد وجود ندارد.");
            return;
        }

        $newCode = rand(100000, 999999);
        (new SmsService())->sendVerificationCode($this->mobile, $newCode);

        if ($record) {
            $record->update([
                'code' => $newCode,
                'expires_at' => now()->addMinutes(5),
                'failed_attempts' => 0,
                'locked_until' => null,
                'used_at' => null,
            ]);
        } else {
            VerificationCode::create([
                'mobile' => $this->mobile,
                'code' => $newCode,
                'expires_at' => now()->addMinutes(5),
                'failed_attempts' => 0,
                'locked_until' => null,
                'used_at' => null,
            ]);
        }

        $this->successMessage = 'کد جدید با موفقیت ارسال شد ✅';
        $this->startCountdown();
        $this->dispatch('code-resent');
    }

    public function verifyCode()
    {
        $this->validate([
            'code' => 'required|digits:6',
        ]);

        $record = VerificationCode::where('mobile', $this->mobile)->latest()->first();

        if (!$record) {
            $this->errorMessage = 'کد یافت نشد، لطفاً مجدداً درخواست دهید.';
            return;
        }

        if ($record->locked_until && now()->lessThan($record->locked_until)) {
            $lockMinutes = ceil(now()->diffInSeconds($record->locked_until) / 60);
            $this->errorMessage = "به دلیل تلاش‌های زیاد، تا {$lockMinutes} دقیقه امکان تلاش نیست.";
            return;
        }

        if ($record->code !== $this->code) {
            $record->increment('failed_attempts');
            if ($record->failed_attempts >= 3) {
                $record->update(['locked_until' => now()->addMinutes(10)]);
                $this->errorMessage = 'به دلیل تلاش‌های متعدد، امکان ارسال کد برای ۱۰ دقیقه مسدود شد.';
            } else {
                $remaining = 3 - $record->failed_attempts;
                $this->errorMessage = "کد اشتباه است. {$remaining} تلاش باقی مانده.";
            }
            return;
        }

        if (now()->greaterThan($record->expires_at)) {
            $this->errorMessage = 'کد منقضی شده است.';
            return;
        }

        if ($record->used_at !== null) {
            $this->errorMessage = 'این کد قبلاً استفاده شده است.';
            return;
        }

        // ✅ همه چیز درست بود
        $record->update(['used_at' => now()]);
        session(['reset_password_mobile' => $this->mobile]);

        return redirect()->route('reset-password');
    }

    public function render()
    {
        return view('livewire.auth.verify-reset-code');
    }
}
