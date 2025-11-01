<?php

namespace App\Livewire\Dashboard\Admin\Shop;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\UserShopOrder;

class AdminShopOrders extends Component
{
    use WithPagination;

    public $search = '';
    public $selectedOrder = null;
    public $showModal = false;
    public $perPage = 10;

    protected $paginationTheme = 'tailwind';
    protected $queryString = ['search'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function showOrderDetails($orderId)
    {
        $this->selectedOrder = UserShopOrder::with('user')->find($orderId);
        $this->showModal = true;
    }

    public function updateStatus($orderId, $status)
    {
        $order = UserShopOrder::find($orderId);
        if ($order) {
            $order->status = $status;
            $order->save();
            $this->dispatch('message', type: 'success', text: 'وضعیت سفارش با موفقیت تغییر کرد.');
        }
    }

    public function render()
    {
        $orders = UserShopOrder::with('user')
            ->whereHas('user', function ($q) {
                $q->where('name', 'like', "%{$this->search}%")
                    ->orWhere('mobile', 'like', "%{$this->search}%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);

        return view('livewire.dashboard.admin.shop.admin-shop-orders', [
            'orders' => $orders,
        ])->layout('components.layouts.admin');
    }
}
