<div class="container-xxl flex-grow-1 container-p-y bg-[#25293c] min-h-screen text-gray-200 px-2 md:px-6">

    @if (session()->has('success'))
        <p>{{ session('success') }}</p>
    @endif

    <!-- جستجو -->
    <input type="text" wire:model.live="search"
           placeholder="جستجو بر اساس نام یا شماره موبایل"
           class="w-full mb-4 p-2 rounded bg-[#1e2235] text-gray-200 focus:outline-none">

    @foreach ($requests as $request)
        <div class="bg-[#1e2235] p-4 rounded-lg shadow mb-3">
            <p class="text-gray-200 font-semibold">کاربر: {{ $request->user->name }}</p>
            <p class="text-gray-400">شماره تماس: {{ $request->user->mobile }}</p>
            <p class="text-gray-400">آدرس: {{ $request->user->address }}</p>
            <p class="text-gray-200">پکیج: {{ $request->packageRequest->package->name }}</p>

            <div class="mt-2 flex gap-2">
                @foreach (['pending', 'approved', 'rejected'] as $status)
                    <button wire:click="updateStatus({{ $request->id }}, '{{ $status }}')"
                            class="px-3 py-1 rounded transition
                                {{ $request->status === $status ? $statusActiveColors[$status] : $statusColors[$status] }}">
                        {{ $statusLabels[$status] }}
                    </button>
                @endforeach
            </div>
        </div>
    @endforeach

    <div class="mt-4">
        {{ $requests->links() }}
    </div>

</div>
