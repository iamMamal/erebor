<div class="authentication-wrapper authentication-basic px-4">
    <div class="authentication-inner py-4">
        <div class="card">

        <div class="card-body">

            <div class="app-brand justify-content-center mb-4 mt-2">

                    <span class="app-brand-text demo text-body fw-bold ms-1">تأیید شماره موبایل</span>

            </div>




<div class="container-xxl flex-grow-1 container-p-y bg-[#25293c] min-h-screen flex items-center justify-center px-4 text-gray-200">
    <div class="bg-[#1f2433] w-full max-w-sm md:max-w-md rounded-2xl p-6 shadow-xl ">
        <p class="text-center mb-4"> ما یک کد تأیید به تلفن همراه {{ $mobile }} ارسال کردیم. کد تایید ارسال شده را در فیلد زیر تایپ کنید.
        </p>

        {{-- پیام خطا یا قفل --}}
        @if ($errorMessage)
            <div class="bg-red-500/10 border border-red-500 text-red-400 text-sm p-2 rounded-lg mb-3 text-center">
                {{ $errorMessage }}
            </div>
        @endif

        @if(isset($record) && $record?->locked_until && now()->lessThan($record->locked_until))
            <div class="bg-red-500/10 border border-red-500 text-red-400 text-sm p-2 rounded-lg mb-3 text-center">
                به دلیل تلاش‌های زیاد، امکان وارد کردن کد یا ارسال مجدد تا
                {{ now()->diffInMinutes($record->locked_until) }} دقیقه دیگر وجود ندارد.
            </div>
        @endif
        {{-- فرم وارد کردن کد --}}
        <form wire:submit.prevent="verifyCode" class="flex flex-col items-center text-center">
            <input
                wire:model="code"
                type="text"
                maxlength="6"
                inputmode="numeric"
                @disabled(isset($record) && $record?->locked_until && now()->lessThan($record->locked_until))
                class="form-control text-center"
                placeholder="کد را وارد کنید"
            />



            <button
                type="submit"
                @disabled(isset($record) && $record?->locked_until && now()->lessThan($record->locked_until))
                class="btn btn-primary d-grid mb-3 waves-effect waves-light mt-2 mx-auto">
                تأیید کد
            </button>
        </form>

        {{-- ارسال مجدد کد و تایمر --}}
        <div class="mt-6 flex flex-col items-center gap-2 text-sm text-center">
            <p wire:ignore id="countdownText" class="text-gray-400 hidden">
                ارسال مجدد کد تا <span id="seconds">{{ $seconds }}</span> ثانیه دیگر
            </p>

            <button
                wire:click="resendCode"
                @disabled($resendDisabled || (isset($record) && $record?->locked_until && now()->lessThan($record->locked_until)))
                class="text-blue-400 disabled:text-gray-600 disabled:cursor-not-allowed underline">
                ارسال مجدد کد
            </button>
        </div>
        @error('code')
        <span class="text-sm text-red-400 mb-2">{{ $message }}</span>
        @enderror
    </div>

    {{-- اسکریپت تایمر --}}
    <script>
        document.addEventListener('livewire:init', () => {
            let timerInterval;

            Livewire.on('start-countdown', () => {
                clearInterval(timerInterval);
                let seconds = 120;
                const secEl = document.getElementById('seconds');
                const btn = document.querySelector('button[wire\\:click="resendCode"]');
                const txt = document.getElementById('countdownText');

                btn.disabled = true;
                txt.classList.remove('hidden');

                timerInterval = setInterval(() => {
                    seconds--;
                    secEl.textContent = seconds;
                    if (seconds <= 0) {
                        clearInterval(timerInterval);
                        btn.disabled = false;
                        txt.classList.add('hidden');
                    }
                }, 1000);
            });

            Livewire.on('code-resent', () => {
                const el = document.createElement('div');
                el.textContent = 'کد جدید ارسال شد ✅';
                el.className = 'text-green-400 text-sm text-center mt-2';
                document.querySelector('.max-w-sm').appendChild(el);
                setTimeout(() => el.remove(), 3000);
            });
        });
    </script>
</div>
    </div>
    </div>
    </div>
</div>
