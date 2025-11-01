<div class="container-xxl flex-grow-1 container-p-y bg-[#25293c] min-h-screen text-gray-200">
    <h2 class="text-xl font-bold mb-4">مدیریت درخواست‌های پکیج</h2>

    {{-- Search --}}
    <div class="mb-4">
        <input type="text" wire:model.live="search" placeholder="جستجو بر اساس نام یا شماره موبایل..."
               class="w-full p-2 rounded bg-gray-700 text-gray-200">
    </div>

    {{-- Requests List --}}
    <table class="w-full text-left border border-gray-600 rounded-lg overflow-hidden">
        <thead class="bg-gray-800">
        <tr>
            <th class="p-2">کاربر</th>
            <th class="p-2">موبایل</th>
            <th class="p-2">پکیج</th>
            <th class="p-2">وضعیت</th>
            <th class="p-2">تاریخ</th>
            <th class="p-2">عملیات</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($requests as $req)
            <tr class="border-b border-gray-700">
                <td class="p-2">{{ $req->user->name }}</td>
                <td class="p-2">{{ $req->user->mobile }}</td>
                <td class="p-2">{{ $req->package->name }}</td>
                <td class="p-2 capitalize">
                    {{ $statusLabels[$req->status] ?? $req->status }}
                    </td>
                <td class="p-2">{{ jalaliDiffForHumans( $req->created_at ) }}</td>
                <td class="p-2 space-x-1">
                    <button wire:click="updateStatus({{ $req->id }}, 'approved')"
                            class="px-2 py-1 bg-green-600 rounded hover:bg-green-500">تأیید</button>
                    <button wire:click="updateStatus({{ $req->id }}, 'rejected')"
                            class="px-2 py-1 bg-red-600 rounded hover:bg-red-500">رد</button>
                    <button wire:click="updateStatus({{ $req->id }}, 'done')"
                            class="px-2 py-1 bg-blue-600 rounded hover:bg-blue-500">انجام شد</button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {{ $requests->links() }}
    </div>
</div>
