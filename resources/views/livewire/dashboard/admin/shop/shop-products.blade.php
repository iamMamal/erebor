<div class="container-xxl flex-grow-1 container-p-y bg-[#25293c] min-h-screen text-gray-200">
    <h2 class="text-2xl font-bold mb-6">مدیریت محصولات فروشگاه 🛒</h2>

    {{-- پیام موفقیت --}}
    @if (session()->has('success'))
        <div class="mb-4 p-3 rounded bg-green-600 text-white">
            {{ session('success') }}
        </div>
    @endif

    {{-- فرم ایجاد / ویرایش --}}
    <div class="bg-gray-800 p-6 rounded-lg shadow mb-8">
        <form wire:submit.prevent="{{ $isEdit ? 'update' : 'store' }}" class="space-y-4">
            <div>
                <label class="block mb-1">نام محصول</label>
                <input type="text" wire:model="name"
                       class="w-full rounded-lg bg-gray-700 border border-gray-600 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('name') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block mb-1">توضیحات</label>
                <textarea wire:model="description"
                          class="w-full rounded-lg bg-gray-700 border border-gray-600 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
            </div>

            <div>
                <label class="block mb-1">قیمت (امتیاز)</label>
                <input type="number" wire:model="price"
                       class="w-full rounded-lg bg-gray-700 border border-gray-600 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('price') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block mb-1">عکس محصول</label>
                <input type="file" wire:model="image"
                       class="w-full text-gray-300 bg-gray-700 border border-gray-600 rounded-lg p-2">
                @if ($image)
                    <img src="{{ $image->temporaryUrl() }}" class="h-24 mt-3 rounded shadow">
                @endif
                @error('image') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="flex items-center space-x-2 space-x-reverse">
                <input type="checkbox" wire:model="is_active" class="h-4 w-4 text-blue-500">
                <span>فعال باشد؟</span>
            </div>

            <div class="flex space-x-3 space-x-reverse">
                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-lg text-white">
                    {{ $isEdit ? 'ویرایش محصول' : 'افزودن محصول' }}
                </button>
                @if($isEdit)
                    <button type="button" wire:click="resetForm"
                            class="bg-gray-600 hover:bg-gray-700 px-4 py-2 rounded-lg text-white">
                        انصراف
                    </button>
                @endif
            </div>
        </form>
    </div>

    {{-- جدول محصولات --}}
    <div class="bg-gray-800 p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold mb-4">لیست محصولات</h3>

        <table class="w-full text-right border-collapse">
            <thead>
            <tr class="bg-gray-700 text-gray-300">
                <th class="p-2">#</th>
                <th class="p-2">نام</th>
                <th class="p-2">قیمت</th>
                <th class="p-2">وضعیت</th>
                <th class="p-2">عکس</th>
                <th class="p-2">عملیات</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($products as $product)
                <tr class="border-b border-gray-600">
                    <td class="p-2">{{ $product->id }}</td>
                    <td class="p-2">{{ $product->name }}</td>
                    <td class="p-2">{{ number_format($product->price) }} امتیاز</td>
                    <td class="p-2">
                        @if($product->is_active)
                            <span class="text-green-400">فعال</span>
                        @else
                            <span class="text-red-400">غیرفعال</span>
                        @endif
                    </td>
                    <td class="p-2">
                        @if($product->image)
                            <img src="{{ asset('storage/'.$product->image) }}" class="h-12 rounded">
                        @endif
                    </td>
                    <td class="p-2 space-x-2 space-x-reverse">
                        <button wire:click="edit({{ $product->id }})"
                                class="bg-yellow-500 hover:bg-yellow-600 px-3 py-1 rounded text-white">
                            ویرایش
                        </button>
                        <button wire:click="delete({{ $product->id }})"
                                class="bg-red-600 hover:bg-red-700 px-3 py-1 rounded text-white">
                            حذف
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center py-4 text-gray-400">
                        هیچ محصولی ثبت نشده 🙁
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
