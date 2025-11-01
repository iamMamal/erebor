<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use App\Models\VerificationCode;
use App\Models\User;
use App\Services\SmsService;
use Carbon\Carbon;

class ForgotPassword extends Component
{
    public $mobile;
    public $seconds = 60;
    public $resendDisabled = false;
    public $errorMessage = null;
    public $successMessage = null;

    public function mount()
    {
        $this->checkResendLock();
    }

    private function checkResendLock()
    {
        $record = VerificationCode::where('mobile', $this->mobile)->latest()->first();

        if ($record) {
            // اگر locked_until هنوز فعاله
            if ($record->locked_until && now()->lessThan($record->locked_until)) {
                $this->resendDisabled = true;
                $diff = now()->diffInSeconds($record->locked_until);
                $this->seconds = $diff;
                $this->dispatch('start-countdown');
            }

            // اگر failed_attempts زیاد بود
            if ($record->failed_attempts >= 3) {
                $this->resendDisabled = true;
                $this->errorMessage = 'به دلیل تلاش‌های زیاد، امکان ارسال کد فعلاً غیرفعال است.';
            }
        }
    }

    public function sendCode()
    {
        $this->validate([
            'mobile' => 'required|numeric|digits:11',
        ]);

        $user = User::where('mobile', $this->mobile)->first();
        if (!$user) {
            $this->errorMessage = 'این شماره در سیستم ثبت نشده است.';
            return;
        }

        $record = VerificationCode::where('mobile', $this->mobile)->latest()->first();

        // بررسی lock و اسپم
        if ($record) {
            if ($record->locked_until && now()->lessThan($record->locked_until)) {
                $minutes = ceil(now()->diffInSeconds($record->locked_until) / 60);
                $this->errorMessage = "به دلیل تلاش‌های زیاد، تا {$minutes} دقیقه امکان ارسال مجدد کد وجود ندارد.";
                $this->resendDisabled = true;
                return;
            }

            if ($record->failed_attempts >= 3) {
                $record->update([
                    'locked_until' => now()->addMinutes(10),
                    'failed_attempts' => 0,
                ]);
                $this->errorMessage = 'تعداد درخواست‌های ارسال کد بیش از حد مجاز بود. لطفاً بعد از ۱۰ دقیقه تلاش کنید.';
                $this->resendDisabled = true;
                return;
            }

            if ($record->created_at->diffInSeconds(now()) < 60) {
                $this->errorMessage = 'لطفاً کمی صبر کنید قبل از ارسال مجدد کد.';
                return;
            }
        }

        // تولید کد جدید
        $code = rand(100000, 999999);

        // ارسال پیامک
        $sms = new SmsService();
        $sms->sendVerificationCode($this->mobile, $code);

        // ذخیره یا آپدیت رکورد
        if ($record) {
            $record->increment('failed_attempts');
            $record->update([
                'code' => $code,
                'expires_at' => now()->addMinutes(5),
                'used_at' => null,
            ]);
        } else {
            VerificationCode::create([
                'mobile' => $this->mobile,
                'code' => $code,
                'expires_at' => now()->addMinutes(5),
                'used_at' => null,
                'failed_attempts' => 0,
                'locked_until' => null,
            ]);
        }

        $this->resendDisabled = true;
        $this->seconds = 60;
        $this->successMessage = 'کد تأیید ارسال شد ✅';
        $this->dispatch('start-countdown');
        $this->dispatch('code-resent');

        // می‌توانیم شماره موبایل رو توی session بگذاریم برای مرحله بعد
        session(['forgot_password_mobile' => $this->mobile]);

        // 🔹 اینجا redirect اضافه می‌کنیم
        return redirect()->route('verify-reset-code');
    }

    public function render()
    {
        return view('livewire.auth.forgot-password');
    }
}
