<div class="container-xxl flex-grow-1 container-p-y bg-[#25293c] min-h-screen text-gray-200 px-2 md:px-6">

    <div class="max-w-lg mx-auto bg-[#2f3349] rounded-2xl p-6 shadow-md mt-6 text-center">
        <h2 class="text-xl font-semibold mb-3 text-gray-100">معرفی اپ به دوستان</h2>

        <!-- متن توضیح (نسخه دوستانه پیش‌فرض) -->
        <p class="mb-2 text-gray-300">
            خوشحال می‌شیم اپ <span class="font-medium text-white">بازیافت</span> رو به دوستات معرفی کنی!
            فقط کافیه دکمه‌ی «معرفی به دوستان» رو بزنی — پیام معرفی و لینک آماده و قابل ارسال می‌شن.
        </p>

        <!-- توضیح کوتاه درباره کانال‌های پشتیبانی -->
        <p class="mb-4 text-sm text-gray-400">
            پشتیبانی شده: پیامک، تلگرام، واتساپ و اشتراک‌گذاری مرورگر (در موبایل).
        </p>

        <button id="shareBtn"
                class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg transition"
                title="ارسال پیام معرفی به دوستان">
            معرفی به دوستان
        </button>
    </div>

    <script>
        (function() {
            const shareBtn = document.getElementById('shareBtn');

            async function shareMessage() {
                // متن و لینک که از سرور میاد (Livewire مقداردهی شده)
                const message = `{{ addslashes($message ?? '') }}`.trim();
                const link = `{{ $link ?? '' }}`.trim();
                const title = `{{ addslashes($title ?? 'معرفی بازیافت') }}`;

                const fullText = message ? `${message}\n${link}` : link;

                // 1) Web Share API (موبایل/مرورگرهای پشتیبانی‌شده)
                if (navigator.share) {
                    try {
                        await navigator.share({
                            title: title,
                            text: fullText,
                            url: link
                        });
                        return;
                    } catch (err) {
                        // کاربر ممکنه کنسل کنه — ادامه به fallback
                        console.log('Share API error or canceled', err);
                    }
                }

                // 2) WhatsApp (اگر کاربر دسکتاپ یا موبایل با wa فعال)
                const whatsapp = `https://wa.me/?text=${encodeURIComponent(fullText)}`;
                // 3) Telegram
                const telegram = `https://t.me/share/url?url=${encodeURIComponent(link)}&text=${encodeURIComponent(message)}`;
                // 4) SMS (mobile)
                const sms = `sms:?&body=${encodeURIComponent(fullText)}`;

                // سعی می‌کنیم اول واتس‌اپ/تلگرام را باز کنیم؛ اگر باز نشد، SMS
                // روی دسکتاپ معمولاً واتس‌اپ وب باز می‌شود، روی موبایل اپ واتس‌اپ.
                // باز کردن در یک پنجره جدید
                const useWhatsApp = true; // می‌تونی اینو false کنی اگر نمی‌خوای واتساپ اول باشد

                if (useWhatsApp) {
                    window.open(whatsapp, '_blank');
                } else {
                    // اگر واتساپ نخواستیم، تلگرام
                    window.open(telegram, '_blank');
                }

                // به عنوان گزینه‌ی جانبی، کاربر ممکنه نیاز داشته باشه SMS بزنه:
                // اگر روی موبایل هستیم و هیچکدوم نصب نیست، می‌تونیم SMS لینک بزنیم:
                // window.location.href = sms;
            }

            shareBtn.addEventListener('click', shareMessage);
        })();
    </script>

</div>
