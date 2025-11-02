@php
    $statusColors = [
        'pending' => 'text-yellow-400 bg-yellow-100/10',
        'approved' => 'text-green-400 bg-green-100/10',
        'rejected' => 'text-red-400 bg-red-100/10',
    ];

    $statusLabels = [
        'pending' => 'در انتظار تایید',
        'approved' => 'تایید شده',
        'rejected' => 'رد شده',
    ];
@endphp

<div class="container-xxl flex-grow-1 container-p-y bg-[#25293c] min-h-screen text-gray-200 px-2 md:px-6">
    <h2 class="text-2xl font-bold mb-8 text-center md:text-left text-transparent bg-clip-text bg-gradient-to-r from-purple-400 via-blue-400 to-cyan-400">
        پکیج‌های تحویل داده شده
    </h2>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
        @foreach ($packages as $packageRequest)
            <div class="relative bg-gradient-to-br from-[#2e335a] via-[#1e2235] to-[#1b1f33] p-5 rounded-2xl shadow-lg hover:shadow-purple-700/40 transition-all duration-300 flex flex-col border border-[#3a3f5c]/40 hover:-translate-y-1">
                <div class="overflow-hidden rounded-xl mb-3">
                    <img loading="lazy" src="{{ $packageRequest->package->image ? asset('storage/' . $packageRequest->package->image) : 'https://via.placeholder.com/150' }}"
                         alt="{{ $packageRequest->package->name }}"
                         class="w-full h-40 object-cover rounded-xl transition-transform duration-300 hover:scale-105">
                </div>

                <h3 class="text-lg font-semibold mb-1 text-purple-300">{{ $packageRequest->package->name }}</h3>
                <p class="text-gray-400 mb-2 flex-grow leading-relaxed text-sm">{{ $packageRequest->package->description }}</p>

                <p class="text-cyan-400 font-semibold mb-3">
                    تاریخ تحویل:
                    <span class="text-gray-300">{{ jalaliDiffForHumans($packageRequest->created_at) }}</span>
                </p>

                @if($packageRequest->clearanceRequest)
                    @php $status = $packageRequest->clearanceRequest->status; @endphp
                    <p class="text-sm font-semibold px-3 py-1.5 rounded-lg text-center {{ $statusColors[$status] }} border border-white/10">
                        وضعیت درخواست تخلیه: {{ $statusLabels[$status] }}
                    </p>
                @else
                    <button wire:click="requestClearance({{ $packageRequest->id }})"
                            wire:loading.attr="disabled"
                            class="mt-auto w-full py-2 bg-gradient-to-r from-red-500 to-pink-500 rounded-xl hover:from-red-400 hover:to-pink-400 transition-all duration-200 shadow-md hover:shadow-pink-700/40 font-semibold">
                        درخواست تخلیه پکیج
                    </button>
                @endif
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
