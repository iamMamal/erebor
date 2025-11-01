<div class="container-xxl">
    <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner py-4">
            <!-- Reset Password Card -->
            <div class="card">
                <div class="card-body">
                    <!-- Logo -->
                    <div class="app-brand justify-content-center mb-4 mt-2">
                        <span class="app-brand-text demo text-body fw-bold ms-1">بازیافت ، اربور</span>
                    </div>

                    <h4 class="mb-1 pt-2">تغییر رمز عبور 🔒</h4>
                    <p class="mb-4">رمز عبور جدید خود را وارد کنید.</p>

                    <form wire:submit.prevent="resetPassword" class="mb-3">
                        <!-- رمز عبور جدید -->
                        <div class="mb-3 form-password-toggle">
                            <label class="form-label" for="password">رمز عبور جدید</label>
                            <div x-data="{ show: false }" class="input-group input-group-merge">
                                <input :type="show ? 'text' : 'password'" type="password" id="password"
                                       wire:model="password" class="form-control" placeholder="••••••••">
                                <span class="input-group-text cursor-pointer">
                                    <i @click="show = !show" :class="{'fa-eye': show}" class="fa-solid fa-eye-slash"></i>
                                </span>
                            </div>
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <!-- تکرار رمز عبور -->
                        <div class="mb-3 form-password-toggle">
                            <label class="form-label" for="password_confirmation">تکرار رمز عبور</label>
                            <div x-data="{ show: false }" class="input-group input-group-merge">
                                <input :type="show ? 'text' : 'password'" type="password" id="password_confirmation"
                                       wire:model="password_confirmation" class="form-control" placeholder="••••••••">
                                <span class="input-group-text cursor-pointer">
                                    <i @click="show = !show" :class="{'fa-eye': show}" class="fa-solid fa-eye-slash"></i>
                                </span>
                            </div>
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                        </div>

                        <!-- پیام خطا -->
                        @if($errorMessage)
                            <div class="alert alert-danger text-center mt-3">
                                {{ $errorMessage }}
                            </div>
                        @endif

                        <!-- پیام موفقیت -->
                        @if($successMessage)
                            <div class="alert alert-success text-center mt-3">
                                {{ $successMessage }}
                            </div>
                        @endif

                        <!-- دکمه تغییر رمز -->
                        <button type="submit" class="btn btn-primary d-grid w-100 waves-effect waves-light">
                            تغییر رمز عبور
                        </button>

                        <div wire:loading wire:target="resetPassword" class="text-center mt-2 text-primary">
                            در حال تغییر رمز عبور...
                        </div>
                    </form>

                    <p class="text-center">
                        <a href="{{ route('login') }}">
                            بازگشت به صفحه ورود
                        </a>
                    </p>
                </div>
            </div>
            <!-- /Reset Password Card -->
        </div>
    </div>
</div>
