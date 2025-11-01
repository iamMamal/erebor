<div class="container-xxl flex-grow-1 container-p-y bg-[#25293c] min-h-screen text-gray-200 px-2 md:px-6">

    <h2 class="text-xl font-bold mb-4">مدیریت سفارش‌ها</h2>

    {{-- نوار جستجو --}}
    <div class="mb-4 flex justify-between items-center">
        <input wire:model.live="search" type="text" placeholder="جستجو بر اساس نام یا شماره موبایل..."
               class="w-full md:w-1/3 bg-gray-700 text-white rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
    </div>

    {{-- جدول سفارش‌ها --}}
    <table class="w-full border-collapse bg-[#2e3150] text-sm rounded-lg overflow-hidden text-center">
        <thead class="bg-[#383c5c]">
        <tr>
            <th class="p-3 text-left">کاربر</th>
            <th class="p-3 text-left">شماره موبایل</th>
            <th class="p-3 text-left">آدرس</th>
            <th class="p-3 text-left">وضعیت</th>
            <th class="p-3 text-left">جزئیات</th>
            <th class="p-3 text-left">عملیات</th>
        </tr>
        </thead>
        <tbody>
        @forelse($orders as $order)
            <tr class="border-b border-gray-700">
                <td class="p-3">{{ $order->user->name ?? '---' }}</td>
                <td class="p-3">{{ $order->user->mobile ?? '---' }}</td>
                <td class="p-3">{{ $order->user->address ?? '---' }}</td>
                <td class="p-3">
                        <span class="px-3 py-1 rounded text-white
                            {{ $order->status == 'pending' ? 'bg-yellow-600' : '' }}
                            {{ $order->status == 'confirmed' ? 'bg-blue-600' : '' }}
                            {{ $order->status == 'processing' ? 'bg-purple-600' : '' }}
                            {{ $order->status == 'delivered' ? 'bg-green-600' : '' }}">
                            {{ $order->status_fa  }}
                        </span>
                </td>
                <td class="p-3">
                    <button wire:click="showOrderDetails({{ $order->id }})"
                            class="bg-gray-600 px-3 py-1 rounded hover:bg-gray-700">مشاهده</button>
                </td>
                <td class="p-3">
                    <select wire:change="updateStatus({{ $order->id }}, $event.target.value)"
                            class="bg-gray-700 text-white rounded px-2 py-1">
                        <option value="">تغییر وضعیت</option>
                        <option value="pending">در انتظار</option>
                        <option value="confirmed">تایید شده</option>
                        <option value="processing">در حال انجام</option>
                        <option value="delivered">تحویل شده</option>
                    </select>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="p-4 text-center text-gray-400">سفارشی یافت نشد.</td>
            </tr>
        @endforelse
        </tbody>
    </table>

    {{-- صفحه‌بندی --}}
    <div class="mt-4">
        {{ $orders->links() }}
    </div>

    {{-- Modal جزئیات سفارش --}}
    @if($showModal && $selectedOrder)
        <div class="fixed inset-0 bg-black bg-opacity-60 flex justify-center items-center z-50">
            <div class="bg-[#2e3150] p-6 rounded-lg w-11/12 md:w-2/3 max-h-[80vh] overflow-y-auto relative">
                <button wire:click="$set('showModal', false)"
                        class="absolute top-2 right-2 bg-red-600 px-3 py-1 rounded text-white">×</button>

                <h3 class="text-lg font-bold mb-4">جزئیات سفارش</h3>
                <p><strong>کاربر:</strong> {{ $selectedOrder->user->name ?? '---' }}</p>
                <p><strong>موبایل:</strong> {{ $selectedOrder->user->mobile ?? '---' }}</p>
                <p><strong>آدرس:</strong> {{ $selectedOrder->user->address ?? '---' }}</p>
                <p><strong>وضعیت:</strong> {{ $selectedOrder->status_fa  }}</p>

                <div class="mt-4">
                    <h4 class="font-semibold mb-2">محصولات:</h4>
                    <ul>
                        @foreach($selectedOrder->productsDetails as $item)
                            <li class="flex items-center mb-2">
                                <img src="{{ $item['product']->image ? asset('storage/' . $item['product']->image) : 'https://via.placeholder.com/150' }}" class="w-12 h-12 rounded object-cover mr-2">
                                <span>{{ $item['product']->name }}</span>
                                <span class="ml-2 text-gray-400">× {{ $item['quantity'] }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

</div>
