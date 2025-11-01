<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class Login extends Component
{
    public $mobile;
    public $password;
    public $errorMessage;

    public function render()
    {
        return view('livewire.auth.login');
    }

    public function login()
    {
        $this->validate([
            'mobile' => ['required', 'regex:/^09\d{9}$/'],
            'password' => ['required', 'min:6'],
        ], [
            'mobile.required' => 'شماره موبایل الزامی است.',
            'mobile.regex' => 'فرمت شماره موبایل معتبر نیست.',
            'password.required' => 'رمز عبور الزامی است.',
            'password.min' => 'رمز عبور باید حداقل ۶ کاراکتر باشد.',
        ]);

        $user = User::where('mobile', $this->mobile)->first();

        if (!$user) {
            $this->addError('mobile', 'کاربری با این شماره یافت نشد.');
            return;
        }

        if (!Auth::attempt(['mobile' => $this->mobile, 'password' => $this->password])) {
            $this->addError('password', 'رمز عبور اشتباه است.');
            return;
        }

        // ✅ ورود موفق
        request()->session()->regenerate();

        // 🚦 بررسی آدرس
        if (empty(Auth::user()->address)) {
            return redirect()->route('user.settings')
                ->with('warning', 'برای ادامه لطفاً آدرس خود را ثبت کنید 🏠')->with('reload', true);
        }

        // ✅ در غیر این صورت، هدایت به داشبورد

        return redirect()->route('admin.dashboard')->with('reload', true);
    }
}
