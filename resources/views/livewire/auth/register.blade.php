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
                    <p class="mb-4">مدیریت برنامه خود را آسان و سرگرم‌کننده کنید!</p>

                    <!-- ✅ فرم Livewire -->
                    <form wire:submit.prevent="register" class="mb-3 fv-plugins-bootstrap5 fv-plugins-framework">

                        <!-- پیام موفقیت (ارسال کد تأیید) -->
                        @if (session()->has('otp'))
                            <div class="alert alert-success text-center">
                                {{ session('otp') }}
                            </div>
                        @endif

                        <!-- فیلد نام -->
                        <div class="mb-3 fv-plugins-icon-container">
                            <label class="form-label" for="name">مشخصات</label>
                            <input wire:model="name" id="name" type="text" name="name" required autofocus autocomplete="name"
                                   class="form-control" placeholder="نام خود را وارد کنید">
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- فیلد شماره موبایل -->
                        <div class="mb-3 fv-plugins-icon-container">
                            <label class="form-label" for="mobile">شماره همراه</label>
                            <input wire:model="mobile" type="tel" name="mobile" required autocomplete="username"
                                   class="form-control" placeholder="0915...">
                            <x-input-error :messages="$errors->get('mobile')" class="mt-2" />
                        </div>

                        <!-- فیلد رمز عبور -->
                        <div class="mb-3 form-password-toggle fv-plugins-icon-container">
                            <label class="form-label" for="password">کلمه عبور</label>
                            <div x-data="{ show: false }" class="input-group input-group-merge has-validation">
                                <input :type="show ? 'text' : 'password'" type="password" name="password"
                                       required autocomplete="new-password"
                                       wire:model="password" id="password"
                                       class="form-control" placeholder="············">
                                <span class="input-group-text cursor-pointer">
                                    <i @click="show = !show" :class="{'fa-eye': show}" class="fa-solid fa-eye-slash"></i>
                                </span>
                            </div>
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <!-- تکرار رمز عبور -->
                        <div class="mb-3 form-password-toggle fv-plugins-icon-container">
                            <label class="form-label" for="password_confirmation">تکرار کلمه عبور</label>
                            <div x-data="{ show: false }" class="input-group input-group-merge has-validation">
                                <input :type="show ? 'text' : 'password'" type="password" name="password_confirmation"
                                       required autocomplete="new-password"
                                       wire:model="password_confirmation" id="password_confirmation"
                                       class="form-control" placeholder="············">
                                <span class="input-group-text cursor-pointer">
                                    <i @click="show = !show" :class="{'fa-eye': show}" class="fa-solid fa-eye-slash"></i>
                                </span>
                            </div>
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                        </div>

                        <!-- چک‌باکس قوانین -->
                        <div class="mb-3 fv-plugins-icon-container">
                            <div class="form-check">
                                <input class="form-check-input" id="terms-conditions" name="terms" type="checkbox">
                                <label class="form-check-label" for="terms-conditions">
                                    من با سیاست
                                    <a href="javascript:void(0);">حفظ حریم خصوصی و شرایط</a>
                                    موافقت می‌کنم
                                </label>
                            </div>
                        </div>

                        <!-- دکمه ثبت نام -->
                        <button class="btn btn-primary d-grid w-100 waves-effect waves-light">ثبت نام</button>

                        <!-- لودینگ -->
                        <div wire:loading wire:target="register" class="text-center mt-2 text-primary">
                            در حال ارسال کد تأیید...
                        </div>

                        <!-- پیام خطا -->
                        @if ($errorMessage ?? false)
                            <div class="alert alert-danger mt-3 text-center">
                                {{ $errorMessage }}
                            </div>
                        @endif

                    </form>

                    <!-- لینک ورود -->
                    <p class="text-center">
                        <span>در حال حاضر حساب کاربری دارید؟</span>
                        <a wire:navigate href="{{ route('login') }}">
                            <span>وارد شوید</span>
                        </a>
                    </p>
                </div>
            </div>
            <!-- /Register Card -->
        </div>
    </div>
</div>
