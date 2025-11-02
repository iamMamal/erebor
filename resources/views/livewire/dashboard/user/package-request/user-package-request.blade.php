<div class="container-xxl flex-grow-1 container-p-y bg-[#25293c] min-h-screen text-gray-200 px-2 md:px-6 py-6">
    <h2 class="text-2xl font-bold mb-8 text-center md:text-left text-white">🎁 پکیج‌های موجود</h2>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
        @foreach ($packages as $package)
            <div class="relative group rounded-2xl overflow-hidden shadow-lg transition-all duration-300 bg-gradient-to-br from-[#7f7eff]/10 via-[#2e3149] to-[#1a1b2f] hover:shadow-[#9b87f5]/40 hover:shadow-2xl">
                <!-- subtle glow overlay -->
                <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-500"
                     style="background: radial-gradient(circle at top left, rgba(155,135,245,0.25), transparent 70%);"></div>

                <div class="relative p-4 flex flex-col h-full">
                    <!-- image -->
                    <div class="w-full h-40 rounded-xl overflow-hidden mb-4">
                        <img src="{{ $package->image ? asset('storage/' . $package->image) : 'https://via.placeholder.com/150' }}"
                             alt="{{ $package->name }}"
                             class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-500">
                    </div>

                    <!-- name -->
                    <h3 class="text-lg font-semibold mb-1 text-white group-hover:text-[#9b87f5] transition">
                        {{ $package->name }}
                    </h3>

                    <!-- description -->
                    <p class="text-gray-400 mb-3 text-sm flex-grow leading-relaxed line-clamp-3">
                        {{ $package->description }}
                    </p>

                    <!-- price -->
                    <div class="flex items-center justify-between">
                        <p class="text-[#ffd166] font-bold text-lg">
                            {{ number_format($package->price) }}
                            <span class="text-sm font-normal text-gray-400">تومان</span>
                        </p>

                        <!-- button -->
                        <button wire:click="requestPackage({{ $package->id }})"
                                wire:loading.attr="disabled"
                                wire:target="requestPackage({{ $package->id }})"
                                class="px-4 py-2 bg-gradient-to-r from-[#9b87f5] to-[#7e6eea] rounded-xl font-medium text-white hover:opacity-90 transition">
                            درخواست
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>


<!-- SweetAlert Listener -->
@if (session()->has('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                icon: 'success',
                title: 'موفقیت!',
                text: '{{ session('success') }}',
                confirmButtonText: 'باشه'
            });
        });
    </script>
@endif

@if (session()->has('error'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                icon: 'error',
                title: 'خطا!',
                text: '{{ session('error') }}',
                confirmButtonText: 'باشه'
            });
        });
    </script>
@endif
