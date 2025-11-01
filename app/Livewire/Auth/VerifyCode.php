<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use App\Models\VerificationCode;
use App\Models\User;
use App\Services\SmsService;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class VerifyCode extends Component
{
    public $mobile;
    public $code;
    public $seconds = 120; // برای تست، بعداً 60 بذار
    public $resendDisabled = true;
    public $errorMessage = null;

    public function mount()
    {
        $this->mobile = session('register_data.mobile');

        if (!$this->mobile) {
            $this->redirectRoute('register', navigate: true);
        }

        $this->checkResendLock();
        $this->startCountdown();
    }

    /**
     * بررسی lock و ریست failed_attempts در صورت گذر زمان
     */
    private function checkResendLock()
    {
        $record = VerificationCode::where('mobile', $this->mobile)->latest()->first();

        if ($record) {
            // اگر locked_until تموم شده بود، failed_attempts رو ریست کن
            if ($record->locked_until && now()->greaterThan($record->locked_until)) {
                $record->update([
                    'failed_attempts' => 0,
                    'locked_until' => null,
                ]);
            }

            // اگر failed_attempts بیش از حد بود، دکمه resend disable
            if ($record->failed_attempts >= 3) {
                $this->resendDisabled = true;
                $this->errorMessage = 'به دلیل تلاش‌های زیاد، امکان ارسال مجدد کد فعلاً غیرفعال است.';
            }
        }
    }

    public function startCountdown()
    {
        $this->resendDisabled = true;
        $this->seconds = 120; // برای تست، بعداً 60 بذار
        $this->dispatch('start-countdown');
    }

    public function resendCode()
    {
        $record = VerificationCode::where('mobile', $this->mobile)->latest()->first();

        // بررسی lock و failed_attempts قبل از ارسال
        if ($record) {
            // اگر locked_until فعال بود
            if ($record->locked_until && now()->lessThan($record->locked_until)) {
                $seconds = now()->diffInSeconds($record->locked_until);
                $minutes = ceil($seconds / 60); // همیشه به بالا گرد می‌کنه
                $this->addError('code', "به دلیل تلاش‌های زیاد، تا {$minutes} دقیقه دیگر امکان ارسال مجدد کد وجود ندارد.");
                return;
            }


            // اگر failed_attempts >= 3 بود
            if ($record->failed_attempts >= 3) {
                $this->resendDisabled = true;
                $this->addError('code', "تعداد درخواست‌های ارسال کد بیش از حد مجاز است.");
                return;
            }

            // جلوگیری از اسپم سریع
            if ($record->created_at->diffInSeconds(now()) < 60) {
                $this->addError('code', 'لطفاً کمی صبر کنید قبل از ارسال مجدد.');
                return;
            }
        }

        // تولید کد جدید
        $newCode = rand(100000, 999999);

        // ارسال پیامک
        $sms = new SmsService();
        $sms->sendVerificationCode($this->mobile, $newCode);

        // ذخیره یا آپدیت رکورد
        if ($record) {
            $record->increment('failed_attempts');

            // اگر بعد از این increment تعداد درخواست ها بیش از حد شد
            if ($record->failed_attempts >= 3) {
                $record->update([
                    'locked_until' => now()->addMinutes(10),
                    'failed_attempts' => 0,
                ]);
                $this->addError('code', 'تعداد درخواست‌های ارسال کد بیش از حد مجاز بود. حساب شما برای ۱۰ دقیقه قفل شد.');
                return;
            }

            // آپدیت کد و زمان انقضا
            $record->update([
                'code' => $newCode,
                'expires_at' => now()->addMinutes(5),
                'used_at' => null,
            ]);
        } else {
            // ایجاد رکورد جدید
            VerificationCode::create([
                'mobile' => $this->mobile,
                'code' => $newCode,
                'expires_at' => now()->addMinutes(5),
                'used_at' => null,
                'failed_attempts' => 0,
                'locked_until' => null,
            ]);
        }

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
            $this->errorMessage = 'کد یافت نشد. لطفاً مجدداً ثبت‌نام کنید.';
            return;
        }

        // بررسی lock
        if ($record->locked_until && now()->lessThan($record->locked_until)) {
            $lockMinutes = Carbon::parse($record->locked_until)->diffInMinutes(now());
            $seconds = now()->diffInSeconds($record->locked_until);
            $minutes = ceil($seconds / 60); // همیشه به بالا گرد می‌کنه
            $this->errorMessage = "به دلیل تلاش‌های ناموفق متعدد، تا {$minutes} دقیقه دیگر نمی‌توانید تلاش کنید.";
            return;
        }

        // بررسی کد اشتباه
        if ($record->code !== $this->code) {
            $record->increment('failed_attempts');

            if ($record->failed_attempts >= 2) {
                $record->update(['locked_until' => now()->addMinutes(10)]);
                $this->errorMessage = 'به دلیل چند تلاش ناموفق، حساب شما برای ۱۰ دقیقه قفل شد.';
            } else {
                $remaining = 2 - $record->failed_attempts;
                $this->errorMessage = "کد نادرست است. {$remaining} تلاش دیگر باقی مانده.";
            }

            return;
        }

        // بررسی انقضا
        if (now()->greaterThan($record->expires_at)) {
            $this->errorMessage = 'کد منقضی شده است.';
            return;
        }

        // بررسی استفاده مجدد
        if ($record->used_at !== null) {
            $this->errorMessage = 'این کد قبلاً استفاده شده است.';
            return;
        }

        // ✅ اگر همه چیز درست بود
        $record->update([
            'used_at' => now(),
            'failed_attempts' => 0,
            'locked_until' => null,
        ]);

        VerificationCode::where('mobile', $this->mobile)
            ->whereNull('used_at')
            ->where('id', '!=', $record->id)
            ->delete();

        $data = session('register_data');
        $user = User::firstOrCreate(['mobile' => $data['mobile']], $data);

        Auth::login($user);
        session()->forget('register_data');

        return redirect()->route('user.settings');
    }

    public function render()
    {
        return view('livewire.auth.verify-code');
    }
}
