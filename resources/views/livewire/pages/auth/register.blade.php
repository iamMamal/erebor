<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered($user = User::create($validated)));

        Auth::login($user);

        $this->redirect(route('dashboard', absolute: false), navigate: true);
    }
}; ?>






{{--<div class="authentication-wrapper authentication-cover authentication-bg">--}}
{{--    <div class="authentication-inner row">--}}
{{--        <!-- /Left Text -->--}}
{{--        <div class="d-none d-lg-flex col-lg-7 p-0">--}}
{{--            <div class="auth-cover-bg auth-cover-bg-color d-flex justify-content-center align-items-center">--}}
{{--                <img alt="auth-register-cover" class="img-fluid my-5 auth-illustration"  src="{{ asset('images/auth-register-illustration-dark.png') }}" >--}}
{{--                <img alt="auth-register-cover" class="platform-bg" src="{{ asset('images/bg-shape-image-dark.png') }}">--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <!-- /Left Text -->--}}
{{--        <!-- Register -->--}}
{{--        <div class="d-flex col-12 col-lg-5 align-items-center p-sm-5 p-4">--}}
{{--            <div class="w-px-400 mx-auto">--}}
{{--                <!-- Logo -->--}}

{{--                <!-- /Logo -->--}}
{{--                <h3 class="mb-1">شروع همه چی از اینجا 🚀</h3>--}}
{{--                <p class="mb-4">مدیریت حسابهای خود را آسان و سرگرم کننده کنید!</p>--}}
{{--                <form  wire:submit="register" class="mb-3 fv-plugins-bootstrap5 fv-plugins-framework">--}}
{{--                    <div class="mb-3 fv-plugins-icon-container">--}}
{{--                        <label class="form-label" for="username">نام کاربری</label>--}}
{{--                        <input wire:model="name" id="name" type="text" name="name" required autofocus autocomplete="name" class="form-control"  placeholder="نام کاربری خود را وارد کنید" >--}}
{{--                        <x-input-error :messages="$errors->get('name')" class="mt-2" />--}}
{{--                    </div>--}}

{{--                    <div class="mb-3 fv-plugins-icon-container">--}}
{{--                        <label class="form-label" for="email">ایمیل</label>--}}
{{--                        <input  wire:model="email"  type="email" name="email" required autocomplete="username"  class="form-control"  placeholder="ایمیل خود را وارد کنید" >--}}
{{--                        <x-input-error :messages="$errors->get('email')" class="mt-2" />--}}
{{--                    </div>--}}


{{--                    <div class="mb-3 form-password-toggle fv-plugins-icon-container">--}}
{{--                        <label class="form-label" for="password">کلمه عبور</label>--}}
{{--                        <div x-data="{ show :  false }" class="input-group input-group-merge has-validation">--}}
{{--                            <input  :type="show ? 'text' : 'password'" type="password"  name="password"--}}
{{--                                    required autocomplete="new-password"--}}
{{--                                    wire:model="password" id="password" aria-describedby="password" class="form-control"  placeholder="············" >--}}
{{--                            <span class="input-group-text cursor-pointer">--}}
{{--                                 <i @click="show = !show"  :class="{'fa-eye' : show}" class="fa-solid fa-eye-slash"></i>--}}
{{--                            </span>--}}
{{--                        </div>--}}
{{--                        <x-input-error :messages="$errors->get('password')" class="mt-2" />--}}
{{--                    </div>--}}




{{--                    <div class="mb-3 form-password-toggle fv-plugins-icon-container">--}}
{{--                        <label class="form-label" for="password">تکرار کلمه عبور</label>--}}
{{--                        <div x-data="{ show :  false }"  class="input-group input-group-merge has-validation">--}}
{{--                            <input  :type="show ? 'text' : 'password'" type="password"  name="password_confirmation"--}}
{{--                                    required autocomplete="new-password"--}}
{{--                                    wire:model="password_confirmation" id="password_confirmation" aria-describedby="password" class="form-control"  placeholder="············" >--}}
{{--                            <span class="input-group-text cursor-pointer">--}}
{{--                                <i @click="show = !show"  :class="{'fa-eye' : show}" class="fa-solid fa-eye-slash"></i>--}}
{{--                            </span>--}}
{{--                        </div>--}}
{{--                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />--}}
{{--                    </div>--}}


{{--                    <div class="mb-3 fv-plugins-icon-container fv-plugins-bootstrap5-row-valid">--}}
{{--                        <div class="form-check">--}}
{{--                            <input class="form-check-input" id="terms-conditions" name="terms" type="checkbox">--}}
{{--                            <label class="form-check-label" for="terms-conditions"> من با سیاست--}}
{{--                                <a>حفظ حریم خصوصی و شرایط</a>--}}
{{--                                موافقت می کنم--}}
{{--                            </label>--}}
{{--                            <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div></div>--}}
{{--                    </div>--}}
{{--                    <button class="btn btn-primary d-grid w-100 waves-effect waves-light">ثبت نام</button>--}}
{{--                    <input type="hidden"></form>--}}
{{--                <p class="text-center">--}}
{{--                    <span>در حال حاضر یک حساب کاربری دارید؟</span>--}}
{{--                    <a wire:navigate href="{{ route('login') }}">--}}
{{--                        <span>وارد شوید</span>--}}
{{--                    </a>--}}
{{--                </p>--}}
{{--                <div class="divider my-4">--}}
{{--                    <div class="divider-text">یا</div>--}}
{{--                </div>--}}
{{--                <div class="d-flex justify-content-center">--}}
{{--                    <a class="btn btn-icon btn-label-facebook me-3 waves-effect">--}}
{{--                        <i class="tf-icons fa-brands fa-facebook-f fs-5"></i>--}}
{{--                    </a>--}}
{{--                    <a class="btn btn-icon btn-label-google-plus me-3 waves-effect" >--}}
{{--                        <i class="tf-icons fa-brands fa-google fs-5"></i>--}}
{{--                    </a>--}}
{{--                    <a class="btn btn-icon btn-label-twitter waves-effect" >--}}
{{--                        <i class="tf-icons fa-brands fa-twitter fs-5"></i>--}}
{{--                    </a>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <!-- /Register -->--}}
{{--    </div>--}}
{{--</div>--}}


<div class="container-xxl">
    <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner py-4">
            <!-- Register Card -->
            <div class="card">
                <div class="card-body">
                    <!-- Logo -->
                    <div class="app-brand justify-content-center mb-4 mt-2">
                        <a class="app-brand-link gap-2">
                            <span class="app-brand-text demo text-body fw-bold ms-1">بازیافت ، اربور</span>
                        </a>
                    </div>
                    <!-- /Logo -->
                    <h4 class="mb-1 pt-2">شروع همه چی از اینجا 🚀</h4>
                    <p class="mb-4">مدیریت برنامه خود را اسان و سرگرم کننده کنید!</p>
                    <form wire:submit="register" class="mb-3 fv-plugins-bootstrap5 fv-plugins-framework" >

                        <div class="mb-3 fv-plugins-icon-container">
                        <label class="form-label" for="username">مشخصات </label>
                        <input wire:model="name" id="name" type="text" name="name" required autofocus autocomplete="name" class="form-control"  placeholder="نام  خود را وارد کنید" >
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                        <div class="mb-3 fv-plugins-icon-container">
                            <label class="form-label" for="email">شماره همراه</label>
                            <input  wire:model="mobile"  type="mobile" name="mobile" required autocomplete="username"  class="form-control"  placeholder="0915..." >
                            <x-input-error :messages="$errors->get('mobile')" class="mt-2" />
                        </div>
                        <div class="mb-3 form-password-toggle fv-plugins-icon-container">
                            <label class="form-label" for="password">کلمه عبور</label>
                            <div x-data="{ show :  false }" class="input-group input-group-merge has-validation">
                                <input  :type="show ? 'text' : 'password'" type="password"  name="password"
                                        required autocomplete="new-password"
                                        wire:model="password" id="password" aria-describedby="password" class="form-control"  placeholder="············" >
                                <span class="input-group-text cursor-pointer">
                                    <i @click="show = !show"  :class="{'fa-eye' : show}" class="fa-solid fa-eye-slash"></i>
                                </span>
                            </div>
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>




                                                <div class="mb-3 form-password-toggle fv-plugins-icon-container">
                                                    <label class="form-label" for="password">تکرار کلمه عبور</label>
                                                    <div x-data="{ show :  false }"  class="input-group input-group-merge has-validation">
                                                        <input  :type="show ? 'text' : 'password'" type="password"  name="password_confirmation"
                                                                required autocomplete="new-password"
                                                                wire:model="password_confirmation" id="password_confirmation" aria-describedby="password" class="form-control"  placeholder="············" >
                                                        <span class="input-group-text cursor-pointer">
                                                            <i @click="show = !show"  :class="{'fa-eye' : show}" class="fa-solid fa-eye-slash"></i>
                                                        </span>
                                                    </div>
                                                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                                                </div>

                            <div class="mb-3 fv-plugins-icon-container">
                            <div class="form-check">
                                <input class="form-check-input" id="terms-conditions" name="terms" type="checkbox">
                                <label class="form-check-label" for="terms-conditions"> من با سیاست
                                    <a href="javascript:void(0);">حفظ حریم خصوصی و شرایط</a>
                                    موافقت می کنم
                                </label>
                                <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div></div>
                        </div>
                        <button class="btn btn-primary d-grid w-100 waves-effect waves-light">ثبت نام</button>
                        <input type="hidden"></form>
                    <p class="text-center">
                        <span>در حال حاضر یک حساب کاربری دارید؟</span>
                        <a wire:navigate href="{{ route('login') }}">
                            <span>وارد شوید</span>
                        </a>
                    </p>
                </div>
            </div>
            <!-- Register Card -->
        </div>
    </div>
</div>
