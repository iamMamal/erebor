<div class="p-4">
    <h2 class="text-xl mb-4">مدیریت بنرها</h2>

    @if (session()->has('message'))
        <div class="mb-2 text-green-700">{{ session('message') }}</div>
    @endif

    <div class="mb-4 p-4 border rounded">
        <input type="text" wire:model="title" placeholder="عنوان (اختیاری)" class="w-full mb-2 p-2">
        <x-input-error :messages="$errors->get('title')" class="mt-2"/>
        <input type="text" wire:model="link" placeholder="لینک (اختیاری)" class="w-full mb-2 p-2">
        <x-input-error :messages="$errors->get('link')" class="mt-2"/>
        <input type="number" wire:model="order" placeholder="ترتیب نمایش (کوچک‌تر اول)" class="w-full mb-2 p-2">
        <x-input-error :messages="$errors->get('order')" class="mt-2"/>
        <label class="inline-flex items-center mb-2">
            <input type="checkbox" wire:model="is_active" class="mr-2"> فعال
        </label>

        <div class="mb-2">
            <input type="file" wire:model="image">
            <x-input-error :messages="$errors->get('image')" class="mt-2"/>
            <div wire:loading wire:target="image">در حال آپلود...</div>
            @if ($image)
                <div class="mt-2">پیش‌نمایش: <img src="{{ $image->temporaryUrl() }}" style="max-height:100px"></div>
            @endif
        </div>

        <div class="flex gap-2">
            <button wire:click="save" class="px-3 py-1 bg-blue-600 text-white rounded">ذخیره</button>
            <button wire:click="resetForm" class="px-3 py-1 bg-gray-300 rounded">انصراف</button>
        </div>
    </div>

    <table class="w-full table-auto border">
        <thead class="bg-gray-100">
        <tr>
            <th class="p-2 border">ID</th>
            <th class="p-2 border">تصویر</th>
            <th class="p-2 border">عنوان</th>
            <th class="p-2 border">لینک</th>
            <th class="p-2 border">ترتیب</th>
            <th class="p-2 border">فعال</th>
            <th class="p-2 border">عملیات</th>
        </tr>
        </thead>
        <tbody>
        @foreach($sliders as $s)
            <tr>
                <td class="p-2 border">{{ $s->id }}</td>
                <td class="p-2 border">
                    @if($s->image)
                        <img src="{{ asset('storage/'.$s->image) }}" style="max-height:60px">
                    @endif
                </td>
                <td class="p-2 border">{{ $s->title }}</td>
                <td class="p-2 border">{{ $s->link }}</td>
                <td class="p-2 border">{{ $s->order }}</td>
                <td class="p-2 border">{{ $s->is_active ? 'بله' : 'خیر' }}</td>
                <td class="p-2 border flex gap-2">
                    <button wire:click="edit({{ $s->id }})" class="px-2 py-1 bg-yellow-500 rounded text-white">ویرایش</button>
                    <button wire:click="delete({{ $s->id }})" class="px-2 py-1 bg-red-500 rounded text-white">حذف</button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
