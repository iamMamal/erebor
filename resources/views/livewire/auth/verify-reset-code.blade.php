<div class="container-xxl">
    <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner py-4">
            <!-- Verify Reset Code Card -->
            <div class="card">
                <div class="card-body">
                    <!-- Logo -->
                    <div class="app-brand justify-content-center mb-4 mt-2">
                        <span class="app-brand-text demo text-body fw-bold ms-1">بازیافت ، اربور</span>
                    </div>

                    <h4 class="mb-1 pt-2">تأیید کد بازیابی 🔐</h4>
                    <p class="mb-4">کد تأیید ارسال شده به شماره <strong>{{ $mobile }}</strong> را وارد کنید.</p>

                    <!-- فرم وارد کردن کد -->
                    <form wire:submit.prevent="verifyCode" class="mb-3">
                        <div class="mb-3">
                            <label class="form-label" for="code">کد تأیید</label>
                            <input wire:model="code" id="code" type="text" name="code" required maxlength="6"
                                   class="form-control text-center fs-5 tracking-widest" placeholder="------" autofocus>
                            <x-input-error :messages="$errors->get('code')" class="mt-2" />
                        </div>

                        <!-- پیام‌ها -->
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

                        <!-- دکمه تأیید -->
                        <button type="submit"
                                wire:loading.attr="disabled"
                                class="btn btn-success d-grid w-100 waves-effect waves-light mb-3">
                            تأیید کد
                        </button>

                        <!-- دکمه ارسال مجدد -->
                        <button type="button"
                                wire:click="resendCode"
                                wire:loading.attr="disabled"
                                class="btn btn-outline-primary d-grid w-100 waves-effect waves-light"
                                id="resendBtn"
                            @disabled($resendDisabled)>
                            ارسال مجدد کد
                        </button>

                        <!-- لودینگ -->
                        <div wire:loading wire:target="verifyCode, resendCode" class="text-center mt-2 text-primary">
                            در حال پردازش...
                        </div>
                    </form>

                    <!-- لینک برگشت -->
                    <p class="text-center">
                        <a href="{{ route('forgot-password') }}" class="text-muted">
                            <span>بازگشت به فراموشی رمز عبور</span>
                        </a>
                    </p>
                </div>
            </div>
            <!-- /Verify Reset Code Card -->
        </div>
    </div>
</div>

{{-- JS برای تایمر ارسال مجدد --}}
<script>
    document.addEventListener('livewire:init', () => {
        let timerInterval;

        Livewire.on('start-countdown', () => {
            clearInterval(timerInterval);
            let seconds = @js($seconds ?? 60);
            const btn = document.getElementById('resendBtn');

            if (!btn) return;
            btn.disabled = true;

            timerInterval = setInterval(() => {
                if (seconds > 0) {
                    btn.textContent = `ارسال مجدد (${seconds})`;
                    seconds--;
                } else {
                    clearInterval(timerInterval);
                    btn.disabled = false;
                    btn.textContent = 'ارسال مجدد کد';
                }
            }, 1000);
        });

        Livewire.on('code-resent', () => {
            const el = document.createElement('div');
            el.textContent = 'کد جدید ارسال شد ✅';
            el.className = 'text-success text-center mt-2';
            document.querySelector('.card-body').appendChild(el);
            setTimeout(() => el.remove(), 3000);
        });
    });
</script>
