<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use App\Models\User;
use App\Models\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class ResetPassword extends Component
{
    public $password;
    public $password_confirmation;
    public $mobile;
    public $errorMessage = null;
    public $successMessage = null;

    public function mount()
    {
        $this->mobile = session('reset_password_mobile');

        if (!$this->mobile) {
            $this->redirectRoute('forgot-password');
        }
    }

    public function resetPassword()
    {
        $this->validate([
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::where('mobile', $this->mobile)->first();

        if (!$user) {
            $this->errorMessage = 'کاربری با این شماره یافت نشد.';
            return;
        }

        // آپدیت رمز عبور
        $user->update([
            'password' => Hash::make($this->password),
        ]);

        // حذف رکوردهای رمز عبور فراموش شده (در صورت استفاده از جدول password_resets)
        PasswordReset::where('mobile', $this->mobile)->delete();

        // پاک کردن session
        session()->forget('reset_password_mobile');

        $this->successMessage = 'رمز عبور با موفقیت تغییر کرد ✅';

        // redirect به صفحه login بعد از 2 ثانیه
        return redirect()->route('login');
    }

    public function render()
    {
        return view('livewire.auth.reset-password');
    }
}
