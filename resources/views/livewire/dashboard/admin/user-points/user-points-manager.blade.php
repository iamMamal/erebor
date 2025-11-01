<div class="container-xxl flex-grow-1 container-p-y bg-[#25293c] min-h-screen text-gray-200">
<h2 class="text-xl font-bold mb-4">مدیریت امتیاز کاربران</h2>

    {{-- Search --}}
    <div class="mb-4">
        <input type="text" wire:model.live="search" placeholder="جستجو بر اساس نام یا شماره موبایل..."
               class="w-full p-2 rounded bg-gray-700 text-gray-200">
    </div>

    {{-- Users List --}}
    <table class="w-full text-left border border-gray-600 rounded-lg overflow-hidden">
        <thead class="bg-gray-800">
        <tr>
            <th class="p-2">نام</th>
            <th class="p-2">موبایل</th>
            <th class="p-2">امتیاز کل</th>
            <th class="p-2">عملیات</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($users as $user)
            <tr class="border-b border-gray-700">
                <td class="p-2">{{ $user->name }}</td>
                <td class="p-2">{{ $user->mobile }}</td>
                <td class="p-2">{{ $user->totalPoints() }}</td>
                <td class="p-2">
                    <button wire:click="selectUser({{ $user->id }})"
                            class="px-3 py-1 bg-indigo-600 rounded hover:bg-indigo-500">
                        مدیریت
                    </button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {{ $users->links() }}
    </div>

    {{-- Modal --}}
    @if ($showModal)
        <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
            <div class="bg-gray-800 rounded-lg shadow-lg w-full max-w-2xl p-6">
                {{-- Header --}}
                <div class="flex justify-between items-center border-b border-gray-700 pb-3 mb-4">
                    <h3 class="text-lg font-bold">مدیریت امتیاز - {{ $selectedUser->name }}</h3>
                    <button wire:click="closeModal" class="text-gray-400 hover:text-gray-200">✖</button>
                </div>

                {{-- User Info --}}
                <p class="mb-4">امتیاز کل:
                    <span class="font-bold text-green-400">{{ $selectedUser->totalPoints() }}</span>
                </p>

                {{-- Add Points Form --}}
                <form wire:submit.prevent="addPoints" class="space-y-3">
                    <input type="number" wire:model="points" placeholder="تعداد امتیاز (+/-)"
                           class="w-full p-2 rounded bg-gray-700 text-gray-200">
                    <input type="text" wire:model="reason" placeholder="دلیل (اختیاری)"
                           class="w-full p-2 rounded bg-gray-700 text-gray-200">

                    <button type="submit"
                            class="px-4 py-2 bg-green-600 rounded hover:bg-green-500">
                        ثبت تغییر
                    </button>
                </form>

                {{-- Points History --}}
                <h4 class="text-md font-bold mt-6 mb-2">تاریخچه امتیازات</h4>
                <div class="max-h-64 overflow-y-auto">
                    <table class="w-full text-left border border-gray-600 rounded">
                        <thead class="bg-gray-700">
                        <tr>
                            <th class="p-2">مقدار</th>
                            <th class="p-2">دلیل</th>
                            <th class="p-2">تاریخ</th>
                            <th class="p-2">عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($this->userPoints as $point)
                            <tr class="border-b border-gray-600">
                                <td class="p-2">{{ $point->points }}</td>
                                <td class="p-2">{{ $point->reason }}</td>
                                <td class="p-2">{{ jalaliDiffForHumans($point->created_at) }}</td>
                                <td class="p-2">
                                    <button wire:click="deletePoint({{ $point->id }})"
                                            class="px-2 py-1 bg-red-600 rounded hover:bg-red-500">
                                        حذف
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Footer --}}
                <div class="flex justify-end mt-4">
                    <button wire:click="closeModal" class="px-4 py-2 bg-gray-600 rounded hover:bg-gray-500">
                        بستن
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
