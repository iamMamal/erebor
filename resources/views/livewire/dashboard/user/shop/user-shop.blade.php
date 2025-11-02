<div class="container-xxl flex-grow-1 container-p-y bg-[#25293c] min-h-screen text-gray-200 px-2 md:px-6">

    <h2 class="text-2xl font-extrabold mb-6 text-white">فروشگاه امتیازی</h2>

    <!-- پیام بالای صفحه -->
    @if($message)
        <div class="p-4 mb-4 rounded-lg {{ $messageType == 'success' ? 'bg-green-700/80 text-green-200' : 'bg-red-700/80 text-red-200' }}">
            {{ $message }}
        </div>
    @endif

    <!-- نمایش امتیاز کاربر -->
    <div class="mb-6 p-4 bg-gradient-to-r from-purple-700 to-blue-700 rounded-lg shadow-lg">
        <p class="text-white">امتیاز فعلی شما: <span class="font-bold text-yellow-400">{{ $userPoints }}</span></p>
    </div>

    <!-- کارت‌های محصولات -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach($products as $product)
            <div class="bg-gradient-to-br from-gray-800/90 via-gray-700/80 to-gray-800/90 p-4 rounded-2xl flex flex-col justify-between shadow-lg hover:shadow-2xl transition-transform duration-300 hover:scale-[1.03]">
                <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/150' }}"
                     alt="{{ $product->name }}"
                     class="w-full h-40 object-cover rounded-lg border border-gray-600 mb-4">
                <div>
                    <h3 class="font-bold text-lg mb-2 text-white">{{ $product->name }}</h3>
                    <p class="text-gray-300 mb-2 text-sm">{{ $product->description }}</p>
                    <p class="text-yellow-400 font-bold mb-2">قیمت: {{ $product->price }} امتیاز</p>
                </div>
                <div class="flex items-center justify-between mt-4">
                    <button wire:click="addToCart({{ $product->id }})"
                            class="bg-green-600 hover:bg-green-700 px-4 py-2 rounded-lg text-white transition duration-200">
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
        <div class="mt-8 p-4 bg-gradient-to-r from-gray-800 to-gray-700 rounded-2xl shadow-lg">
            <h3 class="text-lg font-bold mb-4 text-white">سبد خرید شما</h3>
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
                                        class="bg-red-600 hover:bg-red-700 px-3 py-1 rounded-lg text-white transition duration-200">
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
                        class="bg-blue-600 hover:bg-blue-700 px-5 py-2 rounded-lg text-white transition duration-200">
                    تایید خرید
                </button>
            </div>
        </div>
    @endif

    <!-- دکمه نمایش سفارش‌های قبلی -->
    <button wire:click="loadPreviousOrders" class="bg-gray-600 px-5 py-2 rounded-lg text-white mt-6 mb-4 hover:bg-gray-500 transition duration-200">
        مشاهده سفارش‌های قبلی
    </button>

    <!-- Modal سفارش‌های قبلی -->

    @if($showModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm flex justify-center items-start pt-24 z-50 overflow-y-auto transition-opacity duration-300">
            <div class="bg-gradient-to-br from-gray-900/90 to-gray-800/90 p-6 rounded-3xl w-11/12 md:w-2/3 max-h-[80vh] shadow-2xl transform transition-transform duration-300 scale-95 animate-fade-in relative text-right">

                <!-- دکمه بستن Modal -->
                <button wire:click="$set('showModal', false)"
                        class="absolute top-4 left-4 bg-red-600 px-3 py-1 rounded-full text-white hover:bg-red-700 transition duration-200">×</button>

                <!-- عنوان Modal -->
                <h3 class="text-xl font-bold mb-6 text-white text-center">سفارش‌های قبلی</h3>

                <div class="space-y-4">
                    @foreach($previousOrders as $order)
                        <div class="p-4 bg-gradient-to-r from-purple-700/20 via-blue-700/20 to-purple-700/20 rounded-2xl shadow-inner border border-gray-600">
                            <!-- وضعیت سفارش -->
                            @php
                                $statusLabels = [
                                    'pending' => 'در انتظار',
                                    'approved' => 'تایید شده',
                                    'rejected' => 'رد شده',
                                    'done' => 'تکمیل شده',
                                    'delivered' => 'تحویل شده', // همین خط مهمه
                                ];
                            @endphp

                            <p class="text-white mb-2 font-semibold">
                                وضعیت سفارش: <span class="font-bold">{{ $statusLabels[$order->status] ?? $order->status }}</span>
                                | تاریخ سفارش:
                                <span class="font-bold">
        {{ \Morilog\Jalali\Jalalian::fromCarbon($order->created_at)->format('Y/m/d') }}
    </span>
                            </p>
                            <!-- جزئیات محصولات سفارش -->
                            <ul class="space-y-2">
                                @foreach($order->productsDetails as $item)
                                    <li class="flex items-center gap-3 text-gray-200">
                                        <img src="{{ $item['product']->image ? asset('storage/' . $item['product']->image) : 'https://via.placeholder.com/50' }}"
                                             alt="{{ $item['product']->name }}"
                                             class="w-10 h-10 object-cover rounded-md border border-gray-600">
                                        <span>{{ $item['product']->name }} × {{ $item['quantity'] }}</span>
                                    </li>
                                @endforeach
                            </ul>

                            <!-- جمع امتیاز کل یا هزینه (در صورت نیاز) -->
                            @if(isset($order->totalPoints))
                                <p class="text-yellow-400 font-bold mt-2">جمع امتیاز: {{ $order->totalPoints }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

</div>
