<div class="container-xxl flex-grow-1 container-p-y bg-[#25293c] min-h-screen text-gray-200">
    <h2 class="text-2xl font-bold mb-6">مدیریت پشتیبانی 💬</h2>

    {{-- پیام موفقیت --}}
    @if(session()->has('success'))
        <div class="mb-4 p-3 rounded bg-green-600 text-white">
            {{ session('success') }}
        </div>
    @endif

    {{-- فرم ایجاد / ویرایش --}}
    <div class="bg-gray-800 p-6 rounded-lg shadow mb-8">
        <form wire:submit.prevent="{{ $support_id ? 'update' : 'save' }}" class="space-y-4">

            <div>
                <label class="block mb-1">لینک اینستاگرام</label>
                <input type="url" wire:model="instagram"
                       class="w-full rounded-lg bg-gray-700 border border-gray-600 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('instagram') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block mb-1">شماره موبایل</label>
                <input type="text" wire:model="phone"
                       class="w-full rounded-lg bg-gray-700 border border-gray-600 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('phone') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block mb-1">لینک پیام (WhatsApp / Telegram)</label>
                <input type="url" wire:model="chat_link"
                       class="w-full rounded-lg bg-gray-700 border border-gray-600 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('chat_link') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="flex items-center space-x-2 space-x-reverse">
                <input type="checkbox" wire:model="is_active" class="h-4 w-4 text-blue-500">
                <span>فعال باشد؟</span>
            </div>

            <div class="flex space-x-3 space-x-reverse">
                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-lg text-white">
                    {{ $support_id ? 'ویرایش پشتیبانی' : 'افزودن پشتیبانی' }}
                </button>
                @if($support_id)
                    <button type="button" wire:click="resetForm"
                            class="bg-gray-600 hover:bg-gray-700 px-4 py-2 rounded-lg text-white">
                        انصراف
                    </button>
                @endif
            </div>
        </form>
    </div>

    {{-- جدول پشتیبانی --}}
    <div class="bg-gray-800 p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold mb-4">لیست پشتیبانی</h3>

        <table class="w-full text-right border-collapse">
            <thead>
            <tr class="bg-gray-700 text-gray-300">
                <th class="p-2">#</th>
                <th class="p-2">اینستاگرام</th>
                <th class="p-2">شماره</th>
                <th class="p-2">پیام</th>
                <th class="p-2">وضعیت</th>
                <th class="p-2">عملیات</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($supports as $support)
                <tr class="border-b border-gray-600">
                    <td class="p-2">{{ $support->id }}</td>
                    <td class="p-2"><a href="{{ $support->instagram }}" target="_blank" class="text-blue-400 underline">{{ $support->instagram }}</a></td>
                    <td class="p-2">{{ $support->phone }}</td>
                    <td class="p-2"><a href="{{ $support->chat_link }}" target="_blank" class="text-green-400 underline">ارسال پیام</a></td>
                    <td class="p-2">
                        @if($support->is_active)
                            <span class="text-green-400">فعال</span>
                        @else
                            <span class="text-red-400">غیرفعال</span>
                        @endif
                    </td>
                    <td class="p-2 space-x-2 space-x-reverse">
                        <button wire:click="edit({{ $support->id }})"
                                class="bg-yellow-500 hover:bg-yellow-600 px-3 py-1 rounded text-white">
                            ویرایش
                        </button>
                        <button wire:click="delete({{ $support->id }})"
                                class="bg-red-600 hover:bg-red-700 px-3 py-1 rounded text-white">
                            حذف
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center py-4 text-gray-400">
                        هیچ مورد پشتیبانی ثبت نشده 🙁
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
