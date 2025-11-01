<div class="container-xxl flex-grow-1 container-p-y bg-[#25293c] min-h-screen text-gray-200 px-2 md:px-6">
    <h2 class="text-xl font-bold mb-6 text-center md:text-left">پکیج‌های موجود</h2>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
        @foreach ($packages as $package)
            <div class="bg-[#1e2235] p-4 rounded-lg shadow hover:shadow-lg transition flex flex-col">
                <img src="{{ $package->image ? asset('storage/' . $package->image) : 'https://via.placeholder.com/150' }}"
                     alt="{{ $package->name }}"
                     class="w-full h-36 object-cover rounded mb-3">
                <h3 class="text-lg font-semibold mb-1">{{ $package->name }}</h3>
                <p class="text-gray-400 mb-2 flex-grow">{{ $package->description }}</p>
                <p class="text-yellow-400 font-bold mb-3">قیمت: {{ $package->price }} تومان</p>
                <button wire:click="requestPackage({{ $package->id }})"
                        wire:loading.attr="disabled"
                        wire:target="requestPackage({{ $package->id }})"
                        class="w-full py-2 bg-blue-600 rounded hover:bg-blue-500 transition">
                    درخواست پکیج
                </button>
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
