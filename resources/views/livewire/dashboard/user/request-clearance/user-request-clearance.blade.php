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
    <h2 class="text-xl font-bold mb-6 text-center md:text-left">پکیج‌های تحویل داده شده</h2>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
        @foreach ($packages as $packageRequest)
            <div class="bg-[#1e2235] p-4 rounded-lg shadow hover:shadow-lg transition flex flex-col">
                <img src="{{ $packageRequest->package->image ? asset('storage/' . $packageRequest->package->image) : 'https://via.placeholder.com/150' }}"
                     alt="{{ $packageRequest->package->name }}"
                     class="w-full h-36 object-cover rounded mb-3">
                <h3 class="text-lg font-semibold mb-1">{{ $packageRequest->package->name }}</h3>
                <p class="text-gray-400 mb-2 flex-grow">{{ $packageRequest->package->description }}</p>
                <p class="text-yellow-400 font-bold mb-3">تاریخ تحویل: {{ jalaliDiffForHumans($packageRequest->created_at) }} </p>
                @if($packageRequest->clearanceRequest)
                    @php
                        $status = $packageRequest->clearanceRequest->status;
                    @endphp
                    <p class="text-sm font-semibold px-2 py-1 rounded {{ $statusColors[$status] }}">
                        وضعیت درخواست تخلیه: {{ $statusLabels[$status] }}
                    </p>
                @else
                    <button wire:click="requestClearance({{ $packageRequest->id }})"
                            wire:loading.attr="disabled"
                            class="w-full py-2 bg-red-600 rounded hover:bg-red-500 transition">
                        درخواست تخلیه پکیج
                    </button>
                @endif
            </div>
        @endforeach
    </div>
</div>


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

