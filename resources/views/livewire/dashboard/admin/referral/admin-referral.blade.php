<div class="container-xxl flex-grow-1 container-p-y bg-[#25293c] min-h-screen text-gray-200 px-2 md:px-6">

    <div class="max-w-2xl mx-auto bg-[#2f3349] rounded-2xl p-6 shadow-md mt-6">
        <h2 class="text-xl font-semibold mb-4 text-gray-100">پیام معرفی به دوستان</h2>

        @if (session('success'))
            <div class="bg-green-100 text-green-800 p-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="mb-4">
            <label class="block mb-2 text-sm text-gray-300">عنوان (اختیاری):</label>
            <input type="text" wire:model="title"
                   class="w-full rounded-lg border border-gray-600 bg-[#1e2132] text-gray-100 p-2 focus:ring-2 focus:ring-blue-500">
        </div>

        <div class="mb-4">
            <label class="block mb-2 text-sm text-gray-300">لینک اپ:</label>
            <input type="text" wire:model="link"
                   placeholder="https://bazyaft.app"
                   class="w-full rounded-lg border border-gray-600 bg-[#1e2132] text-gray-100 p-2 focus:ring-2 focus:ring-blue-500">
        </div>

        <div class="mb-4">
            <label class="block mb-2 text-sm text-gray-300">متن پیام:</label>
            <textarea wire:model="message" rows="5"
                      placeholder="سلام 👋 من از اپ بازیافت استفاده می‌کنم..."
                      class="w-full rounded-lg border border-gray-600 bg-[#1e2132] text-gray-100 p-2 focus:ring-2 focus:ring-blue-500"></textarea>
        </div>

        <button wire:click="save"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition">
            ذخیره پیام
        </button>
    </div>

</div>
