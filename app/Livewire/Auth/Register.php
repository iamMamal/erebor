<?php

namespace App\Livewire\Auth;

use App\Services\SmsService;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Illuminate\Support\Facades\Validator;
use App\Models\VerificationCode;
use Illuminate\Support\Str;
use Carbon\Carbon;

class Register extends Component
{
    public $name;
    public $mobile;
    public $password;
    public $password_confirmation;
    public $errorMessage;

    public function register()
    {

        // 🔍 بررسی صحت ورودی‌ها
        $validated = Validator::make([
            'name' => $this->name,
            'mobile' => $this->mobile,
            'password' => $this->password,
            'password_confirmation' => $this->password_confirmation,
        ], [
            'name' => 'required|string|min:3',
            'mobile' => [
                'required',
                'digits:11',
                'regex:/^09[0-9]{9}$/',
                'unique:users,mobile'
            ],
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required',
        ], [
            'name.required' => 'نام الزامی است.',
            'mobile.required' => 'شماره موبایل الزامی است.',
            'mobile.digits' => 'شماره موبایل باید ۱۱ رقم باشد.',
            'mobile.regex' => 'شماره موبایل باید با ۰۹ شروع شود.',
            'mobile.unique' => 'این شماره موبایل قبلاً ثبت شده است.',
            'password.required' => 'رمز عبور الزامی است.',
            'password.min' => 'رمز عبور باید حداقل ۶ کاراکتر باشد.',
            'password.confirmed' => 'تأیید رمز عبور مطابقت ندارد.',
        ])->validate();

        $code = rand(100000, 999999); // تولید کد 6 رقمی
        // ذخیره موقت اطلاعات در سشن برای مرحله بعد
        session([
            'register_data' => [
                'name'     => $this->name,
                'mobile'   => $this->mobile,
                'password' => Hash::make($this->password),
            ]
        ]);

        // ذخیره کد در جدول VerificationCode
        VerificationCode::updateOrCreate(
            ['mobile' => $this->mobile],
            [
                'code'       => $code,
                'expires_at' => now()->addMinutes(5),
                'used_at'    => null,
            ]
        );

        // ارسال پیامک با سرویس ملی‌پیامک
        $sms = new SmsService();
        $sms->sendVerificationCode($this->mobile, $code);

        // هدایت به صفحه وارد کردن کد
        return redirect()->route('verify.code');
        }

    public function render()
    {
        return view('livewire.auth.register');
    }
}
