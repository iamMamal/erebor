<?php

namespace App\Livewire\Dashboard\Admin\Shop;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\ShopProduct;

class ShopProducts extends Component
{
    use WithFileUploads;

    public $products, $name, $description, $price, $image, $is_active = true;
    public $product_id;
    public $isEdit = false;

    public function render()
    {
        $this->products = ShopProduct::orderBy('id', 'desc')->get();
        return view('livewire.dashboard.admin.shop.shop-products')
            ->layout('components.layouts.admin'); // همون لایوت دارک
    }

    public function resetForm()
    {
        $this->name = '';
        $this->description = '';
        $this->price = '';
        $this->image = '';
        $this->is_active = true;
        $this->isEdit = false;
    }

    public function store()
    {
        $this->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'image' => $this->isEdit ? 'nullable|image|max:2048' : 'required|image|max:2048',
        ]);

        $path = null;
        if ($this->image) {
            $path = $this->image->store('shop_products', 'public');
        }

        ShopProduct::create([
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'image' => $path,
            'is_active' => $this->is_active,
        ]);

        $this->resetForm();
        session()->flash('success', 'محصول با موفقیت اضافه شد ✅');
    }

    public function edit($id)
    {
        $product = ShopProduct::findOrFail($id);
        $this->product_id = $product->id;
        $this->name = $product->name;
        $this->description = $product->description;
        $this->price = $product->price;
        $this->is_active = $product->is_active;
        $this->isEdit = true;
    }

    public function update()
    {
        $this->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'image' => 'nullable|image|max:2048',
        ]);

        $product = ShopProduct::findOrFail($this->product_id);

        $path = $product->image;
        if ($this->image) {
            $path = $this->image->store('shop_products', 'public');
        }

        $product->update([
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'image' => $path,
            'is_active' => $this->is_active,
        ]);

        $this->resetForm();
        session()->flash('success', 'محصول با موفقیت ویرایش شد ✏️');
    }

    public function delete($id)
    {
        $product = ShopProduct::findOrFail($id);
        $product->delete();
        session()->flash('success', 'محصول حذف شد 🗑️');
    }
}
