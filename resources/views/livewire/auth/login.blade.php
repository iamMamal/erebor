<div class="container-xxl">
    <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner py-4">
            <!-- Login Card -->
            <div class="card">
                <div class="card-body">
                    <!-- Logo -->
                    <div class="app-brand justify-content-center mb-4 mt-2">
                        <a class="app-brand-link gap-2">
                            <span class="app-brand-text demo text-body fw-bold ms-1">بازیافت ، اربور</span>
                        </a>
                    </div>
                    <!-- /Logo -->

                    <h4 class="mb-1 pt-2">خوش اومدی دوباره 👋</h4>
                    <p class="mb-4">برای ورود به حساب خود، اطلاعات زیر را وارد کنید.</p>

                    <!-- ✅ فرم ورود -->
                    <form wire:submit.prevent="login" class="mb-3 fv-plugins-bootstrap5 fv-plugins-framework">

                        <!-- فیلد شماره موبایل -->
                        <div class="mb-3 fv-plugins-icon-container">
                            <label class="form-label" for="mobile">شماره همراه</label>
                            <input wire:model="mobile" type="tel" name="mobile" required autocomplete="username"
                                   class="form-control" placeholder="0915..." autofocus>
                            <x-input-error :messages="$errors->get('mobile')" class="mt-2" />
                        </div>

                        <!-- فیلد رمز عبور -->
                        <div class="mb-3 form-password-toggle fv-plugins-icon-container">
                            <label class="form-label" for="password">کلمه عبور</label>
                            <div x-data="{ show: false }" class="input-group input-group-merge has-validation">
                                <input :type="show ? 'text' : 'password'" type="password" name="password"
                                       required autocomplete="current-password"
                                       wire:model="password" id="password"
                                       class="form-control" placeholder="············">
                                <span class="input-group-text cursor-pointer">
                                    <i @click="show = !show" :class="{'fa-eye': show}" class="fa-solid fa-eye-slash"></i>
                                </span>
                            </div>
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <!-- پیام خطا -->
                        @if ($errorMessage)
                            <div class="alert alert-danger text-center mt-3">
                                {{ $errorMessage }}
                            </div>
                        @endif

                        <!-- دکمه ورود -->
                        <button type="submit" class="btn btn-primary d-grid w-100 waves-effect waves-light">
                            ورود
                        </button>

                        <!-- لودینگ -->
                        <div wire:loading wire:target="login" class="text-center mt-2 text-primary">
                            در حال بررسی اطلاعات...
                        </div>
                    </form>

                    <!-- لینک ثبت نام -->
                    <p class="text-center">
                        <span>حساب کاربری ندارید؟</span>
                        <a wire:navigate href="{{ route('register') }}">
                            <span>ثبت‌نام کنید</span>
                        </a>
                    </p>
                    <p class="text-center mt-3">
                        <span>رمز خود را فراموش کرده اید ؟</span>
                        <a wire:navigate href="{{ route('forgot-password') }}">
                            <span>فراموشی کلمه عبور</span>
                        </a>
                    </p>
                </div>
            </div>
            <!-- /Login Card -->
        </div>
    </div>
</div>
