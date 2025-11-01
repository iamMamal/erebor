<div class="container-xxl">
    <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner py-4">
            <!-- Forgot Password Card -->
            <div class="card">
                <div class="card-body">
                    <!-- Logo -->
                    <div class="app-brand justify-content-center mb-4 mt-2">
                        <span class="app-brand-text demo text-body fw-bold ms-1">بازیافت ، اربور</span>
                    </div>

                    <h4 class="mb-1 pt-2">فراموشی رمز عبور 💬</h4>
                    <p class="mb-4">شماره موبایل خود را وارد کنید تا کد تأیید برای شما ارسال شود.</p>

                    <!-- فرم -->
                    <form wire:submit.prevent="sendCode" class="mb-3">
                        <div class="mb-3">
                            <label class="form-label" for="mobile">شماره همراه</label>
                            <input wire:model="mobile" id="mobile" type="tel" name="mobile" required
                                   class="form-control" placeholder="0915..." autofocus>
                            <x-input-error :messages="$errors->get('mobile')" class="mt-2" />
                        </div>

                        @if($successMessage)
                            <div class="alert alert-success text-center mt-3">
                                {{ $successMessage }}
                            </div>
                        @endif

                        @if($errorMessage)
                            <div class="alert alert-danger text-center mt-3">
                                {{ $errorMessage }}
                            </div>
                        @endif

                        <button type="submit"
                                wire:loading.attr="disabled"
                                class="btn btn-primary d-grid w-100 waves-effect waves-light"
                                id="sendCodeBtn">
                            ارسال کد
                        </button>

                        <div wire:loading wire:target="sendCode" class="text-center mt-2 text-primary">
                            در حال ارسال کد...
                        </div>
                    </form>

                    <p class="text-center">
                        <span>کد را دریافت کردید؟</span>
                        <a href="{{ route('verify-reset-code') }}">
                            <span>وارد کردن کد</span>
                        </a>
                    </p>
                </div>
            </div>
            <!-- /Forgot Password Card -->
        </div>
    </div>
</div>

{{-- JS برای تایمر ارسال مجدد کد --}}
<script>
    document.addEventListener('livewire:init', () => {
        let timerInterval;

        Livewire.on('start-countdown', () => {
            clearInterval(timerInterval);
            let seconds = @js($seconds ?? 60);
            const btn = document.getElementById('sendCodeBtn');

            if (!btn) return;
            btn.disabled = true;

            timerInterval = setInterval(() => {
                if (seconds > 0) {
                    btn.textContent = `ارسال مجدد (${seconds})`;
                    seconds--;
                } else {
                    clearInterval(timerInterval);
                    btn.disabled = false;
                    btn.textContent = 'ارسال کد';
                }
            }, 1000);
        });

        Livewire.on('code-resent', () => {
            const el = document.createElement('div');
            el.textContent = 'کد ارسال شد ✅';
            el.className = 'text-success text-center mt-2';
            document.querySelector('.card-body').appendChild(el);
            setTimeout(() => el.remove(), 3000);
        });
    });
</script>
