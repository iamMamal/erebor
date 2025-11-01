<?php

namespace App\Livewire\Dashboard\User\Shop;

use App\Models\User;
use Livewire\Component;
use App\Models\ShopProduct;
use App\Models\UserShopOrder;
use App\Models\UserPoint;
use Illuminate\Support\Facades\Auth;

class UserShop extends Component
{
    public $products = [];
    public $cart = [];
    public $userPoints = 0;

    public $message = '';
    public $messageType = '';

    public $previousOrders = [];
    public $showModal = false;

    public function mount()
    {


        $user = Auth::user();

        $this->products = ShopProduct::where('is_active', true)->get();
        $this->loadUserCart();
        $this->loadUserPoints();
    }

    public function loadUserCart()
    {
        $order = UserShopOrder::where('user_id', Auth::id())
            ->where('status', 'pending')
            ->first();

        $this->cart = $order ? $order->products : [];
    }

    public function loadUserPoints()
    {
        $this->userPoints = UserPoint::where('user_id', Auth::id())->sum('points');
    }

    public function showMessage($type, $text)
    {
        $this->messageType = $type;
        $this->message = $text;
        $this->dispatch('messageCleared', ['timeout' => 3000]);
    }

    public function addToCart($productId)
    {
        $product = ShopProduct::find($productId);
        if (!$product) return;

        $currentQuantity = $this->cart[$productId]['quantity'] ?? 0;
        $totalPrice = $product->price * ($currentQuantity + 1);

        if ($totalPrice > $this->userPoints) {
            $this->showMessage('error', 'امتیاز کافی نیست');
            return;
        }

        $this->cart[$productId] = [
            'product_id' => $productId,
            'quantity' => $currentQuantity + 1,
        ];

        $this->saveCart();
        $this->showMessage('success', 'محصول به سبد اضافه شد');
    }

    public function updateQuantity($productId, $quantity)
    {
        $quantity = (int)$quantity;
        if ($quantity < 1) {
            unset($this->cart[$productId]);
        } else {
            $product = ShopProduct::find($productId);
            if (!$product) return;

            $totalPrice = $product->price * $quantity;
            if ($totalPrice > $this->userPoints) {
                $this->showMessage('error', 'امتیاز کافی نیست');
                return;
            }

            $this->cart[$productId]['quantity'] = $quantity;
        }

        $this->saveCart();
    }

    public function saveCart()
    {
        $order = UserShopOrder::firstOrNew([
            'user_id' => Auth::id(),
            'status' => 'pending',
        ]);

        $order->products = $this->cart;
        $order->save();
    }

    public function confirmPurchase()
    {
        $totalPoints = 0;
        foreach ($this->cart as $item) {
            $product = ShopProduct::find($item['product_id']);
            if ($product) $totalPoints += $product->price * $item['quantity'];
        }

        if ($totalPoints > $this->userPoints) {
            $this->showMessage('error', 'امتیاز کافی نیست');
            return;
        }

        UserPoint::create([
            'user_id' => Auth::id(),
            'points' => -$totalPoints,
            'reason' => 'خرید محصولات در فروشگاه',
        ]);

        $order = UserShopOrder::where('user_id', Auth::id())
            ->where('status', 'pending')
            ->first();

        if ($order) {
            $order->status = 'confirmed';
            $order->confirmed = true;
            $order->save();
        }

        $this->cart = [];
        $this->loadUserPoints();
        $this->showMessage('success', 'سفارش شما با موفقیت تایید شد');
    }

    public function loadPreviousOrders()
    {
        $this->previousOrders = UserShopOrder::where('user_id', Auth::id())
            ->where('status', '!=', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();

        $this->showModal = true;
    }

    public function render()
    {
        return view('livewire.dashboard.user.shop.user-shop')
            ->layout('components.layouts.admin');
    }
}
