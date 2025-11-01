<div class="container-xxl flex-grow-1 container-p-y bg-[#25293c] min-h-screen text-gray-200 px-2 md:px-6">

    <h2 class="text-xl font-bold mb-4">فروشگاه امتیازی</h2>

    <!-- پیام بالای صفحه -->
    @if($message)
        <div class="p-4 mb-4 rounded {{ $messageType == 'success' ? 'bg-green-600' : 'bg-red-600' }}">
            {{ $message }}
        </div>
    @endif

    <!-- نمایش امتیاز کاربر -->
    <div class="mb-6 p-4 bg-gray-800 rounded-lg">
        <p>امتیاز فعلی شما: <span class="font-bold">{{ $userPoints }}</span></p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        @foreach($products as $product)
            <div class="bg-gray-700 p-4 rounded-lg flex flex-col justify-between">
                <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/150' }}"
                     alt="{{ $product->name }}"
                     class="w-full h-36 object-cover rounded mb-3">
                <div>
                    <h3 class="font-bold text-lg mb-2">{{ $product->name }}</h3>
                    <p class="text-gray-300 mb-2">{{ $product->description }}</p>
                    <p class="text-yellow-400 font-bold mb-2">قیمت: {{ $product->price }} امتیاز</p>
                </div>
                <div class="flex items-center justify-between mt-4">
                    <button wire:click="addToCart({{ $product->id }})"
                            class="bg-green-600 hover:bg-green-700 px-3 py-1 rounded text-white">
                        افزودن به سبد
                    </button>
                    @if(isset($cart[$product->id]))
                        <span class="text-gray-300">تعداد: {{ $cart[$product->id]['quantity'] }}</span>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    <!-- سبد خرید کاربر -->
    @if(count($cart) > 0)
        <div class="mt-8 p-4 bg-gray-800 rounded-lg">
            <h3 class="text-lg font-bold mb-4">سبد خرید شما</h3>
            <table class="w-full text-left text-gray-200">
                <thead>
                <tr>
                    <th class="py-2">محصول</th>
                    <th class="py-2">تعداد</th>
                    <th class="py-2">عملیات</th>
                </tr>
                </thead>
                <tbody>
                @foreach($cart as $item)
                    @php
                        $product = \App\Models\ShopProduct::find($item['product_id']);
                    @endphp
                    @if($product)
                        <tr class="border-b border-gray-600">
                            <td class="py-2">{{ $product->name }}</td>
                            <td class="py-2">
                                <input type="number" min="1"
                                       wire:change="updateQuantity({{ $product->id }}, $event.target.value)"
                                       value="{{ $item['quantity'] }}"
                                       class="w-16 text-black rounded px-1">
                            </td>
                            <td class="py-2">
                                <button wire:click="updateQuantity({{ $product->id }}, 0)"
                                        class="bg-red-600 hover:bg-red-700 px-2 py-1 rounded text-white">
                                    حذف
                                </button>
                            </td>
                        </tr>
                    @endif
                @endforeach
                </tbody>
            </table>

            <div class="mt-4 flex justify-end">
                <button wire:click="confirmPurchase"
                        class="bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded text-white">
                    تایید خرید
                </button>
            </div>
        </div>
    @endif

    <!-- دکمه نمایش سفارش‌های قبلی -->
    <button wire:click="loadPreviousOrders" class="bg-gray-600 px-4 py-2 rounded text-white mt-6 mb-4">
        مشاهده سفارش‌های قبلی
    </button>

    <!-- Modal سفارش‌های قبلی -->
    @if($showModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
            <div class="bg-gray-800 p-6 rounded-lg w-11/12 md:w-2/3 max-h-[80vh] overflow-y-auto relative">
                <button wire:click="$set('showModal', false)"
                        class="absolute top-2 right-2 bg-red-600 px-2 py-1 rounded text-white">×</button>

                <h3 class="text-lg font-bold mb-4">سفارش‌های قبلی</h3>

                @foreach($previousOrders as $order)
                    <div class="mb-4 p-4 bg-gray-700 rounded">
                        <p>وضعیت: <span class="font-bold">{{ $order->status }}</span></p>
                        <ul class="mt-2">
                            @foreach($order->productsDetails as $item)
                                <li class="flex items-center mb-1">
                                    <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/150' }}" alt="{{ $item['product']->name }}" class="w-10 h-10 object-cover rounded mr-2">
                                    {{ $item['product']->name }} × {{ $item['quantity'] }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
