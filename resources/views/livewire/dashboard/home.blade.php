<div class="container-xxl flex-grow-1 container-p-y bg-[#25293c] min-h-screen text-gray-200 px-3 md:px-6 py-6 space-y-6">

    <!-- خوش آمدگویی -->
    <div class="text-center">
        <h1 class="text-2xl md:text-3xl font-bold text-white">
            👋 سلام {{ $userName }}، خوش اومدی به <span class="text-[#9b87f5]">اربور</span>
        </h1>
        <p class="text-gray-400 mt-3 text-center text-xl" id="datetime">...</p>
    </div>

    <!-- اسلایدر -->
    <div class="relative w-full rounded-2xl overflow-hidden">
        <div class="swiper mySwiper">
            <div class="swiper-wrapper">
                @foreach($sliders as $slider)
                    @php
                        $link = trim($slider->link ?? '');
                        $isExternal = Str::startsWith($link, ['http://', 'https://']);
                        $isInternal = !$isExternal && $link !== '';
                    @endphp

                    <div class="swiper-slide">
                        @if ($isExternal)
                            {{-- لینک خارجی: باز شدن در مرورگر گوشی --}}
                            <a href="{{ $link }}" target="_blank" rel="noopener noreferrer">
                                <img
                                    src="{{ asset('storage/' . $slider->image) }}"
                                    alt="{{ $slider->title }}"
                                    class="w-full h-56 object-cover rounded-2xl">
                            </a>

                        @elseif ($isInternal)
                            {{-- لینک داخلی: باز شدن درون PWA با wire:navigate --}}
                            <a wire:navigate href="{{ $link }}">
                                <img
                                    src="{{ asset('storage/' . $slider->image) }}"
                                    alt="{{ $slider->title }}"
                                    class="w-full h-56 object-cover rounded-2xl">
                            </a>

                        @else
                            {{-- بدون لینک --}}
                            <img
                                src="{{ asset('storage/' . $slider->image) }}"
                                alt="{{ $slider->title }}"
                                class="w-full h-56 object-cover rounded-2xl">
                        @endif
                    </div>
                @endforeach

            </div>

            <div class="swiper-pagination !bottom-1"></div>
        </div>
    </div>

    <!-- دکمه‌های عملیات -->
    <div class="grid grid-cols-2 gap-4">
        <!-- دکمه درخواست پکیج -->
        <a
            wire:navigate
            href="{{ route('dashboard.user.pkg-request') }}"
            class="bg-gradient-to-r from-[#ff9966] to-[#ff5e62] p-5 rounded-2xl shadow-md flex flex-col items-center justify-center hover:scale-105 transition-all">
            <span class="text-3xl mb-2">📦</span>
            <span class="font-semibold text-white">درخواست پکیج</span>
        </a>

        <!-- دکمه تخلیه بار -->
        <a
            wire:navigate
            href="{{ route('dashboard.user.clearance-request') }}"
            class="bg-gradient-to-r from-[#56ab2f] to-[#a8e063] p-5 rounded-2xl shadow-md flex flex-col items-center justify-center hover:scale-105 transition-all">
            <span class="text-3xl mb-2">🚚</span>
            <span class="font-semibold text-white">تخلیه بار</span>
        </a>
    </div>

    <!-- بخش نکته روز -->
    <div>
        <livewire:dashboard.tips />
    </div>
    <!-- بخش پشتیبانی و تبلیغ -->
    <!-- بخش پشتیبانی و تبلیغ full-width -->
    @if(count($supports) > 0)
        <div class="mt-6 space-y-4">
            @foreach($supports as $support)
                <div class="w-full bg-gradient-to-r from-[#6a11cb]/50 to-[#2575fc]/50 p-5 rounded-2xl shadow-md flex flex-col md:flex-row items-center justify-between hover:scale-105 transition-all">

                    <div class="flex flex-col md:flex-row md:items-center space-y-2 md:space-y-0 md:space-x-6 w-full">
                        @if($support->instagram)
                            <a href="{{ $support->instagram }}" target="_blank" class="mx-2 flex items-center text-pink-400 font-semibold hover:underline">
                                📸 اینستاگرام
                            </a>
                        @endif

                        @if($support->chat_link)
                            <a href="{{ $support->chat_link }}" target="_blank" class=" mx-2 flex items-center text-blue-400 font-semibold hover:underline">
                                💬 تلگرام
                            </a>
                        @endif

                        @if($support->phone)
                            <a href="tel:{{ $support->phone }}" class=" mx-2flex items-center text-green-400 font-semibold hover:underline">
                                📞 تماس با پشتیبانی: {{ $support->phone }}
                            </a>
                        @endif
                    </div>

                </div>
            @endforeach
        </div>
    @endif



    <style>
        .swiper {
            width: 100%;
            height: auto;
        }

        .swiper-slide img {
            width: 100%;
            height: 220px;
            object-fit: cover;
            border-radius: 1rem;
        }

        /* برای تبلت‌ها */
        @media (min-width: 768px) {
            .swiper-slide img {
                height: 300px;
            }
        }

        /* برای دسکتاپ */
        @media (min-width: 1024px) {
            .swiper-slide img {
                height: 400px;
            }
        }

        /* برای مانیتورهای خیلی بزرگ */
        @media (min-width: 1440px) {
            .swiper-slide img {
                height: 480px;
            }
        }
    </style>

</div>

@push('scripts')
    <!-- Swiper CSS & JS -->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"
    />
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <script>
        // Swiper initialization after Livewire navigation
        document.addEventListener('livewire:navigated', initSwiper);
        document.addEventListener('DOMContentLoaded', initSwiper);

        function initSwiper() {
            const swiperEl = document.querySelector('.mySwiper');
            if (!swiperEl) return;

            // جلوگیری از دوباره‌سازی Swiper
            if (swiperEl.swiper) {
                swiperEl.swiper.destroy(true, true);
            }

            new Swiper('.mySwiper', {
                loop: true,
                rtl: true,
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                autoplay: {
                    delay: 3500,
                    disableOnInteraction: false,
                },
                speed: 700,
            });
        }

        // تاریخ و ساعت فارسی
        document.addEventListener('livewire:navigated', updatePersianDateTime);
        document.addEventListener('DOMContentLoaded', updatePersianDateTime);

        function updatePersianDateTime() {
            const datetimeEl = document.getElementById('datetime');
            if (!datetimeEl) return;

            function formatDateTime() {
                const now = new Date();
                const weekday = new Intl.DateTimeFormat('fa-IR', { weekday: 'long' }).format(now);
                const day = new Intl.DateTimeFormat('fa-IR', { day: 'numeric' }).format(now);
                const month = new Intl.DateTimeFormat('fa-IR', { month: 'long' }).format(now);
                const year = new Intl.DateTimeFormat('fa-IR', { year: 'numeric' }).format(now);
                const time = new Intl.DateTimeFormat('fa-IR', { hour: '2-digit', minute: '2-digit' }).format(now);

                datetimeEl.textContent = `${weekday}  ${day} ${month} ${year} - ساعت ${time}`;
            }

            formatDateTime();
            setInterval(formatDateTime, 60000);
        }
    </script>
@endpush
