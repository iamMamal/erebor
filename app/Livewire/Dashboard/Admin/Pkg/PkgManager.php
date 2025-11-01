<?php

namespace App\Livewire\Dashboard\Admin\Pkg;


use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Package;

class PkgManager extends Component
{
    use WithPagination, WithFileUploads;

    public $name, $description, $price, $image, $is_active = true;
    public $editId = null;
    public $isEdit = false;

    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'price' => 'required|numeric|min:0',
        'image' => 'nullable|image|max:2048', // 2MB
        'is_active' => 'boolean',
    ];

    public function render()
    {
        $packages = Package::latest()->paginate(10);
        return view('livewire.dashboard.admin.pkg.pkg-manager', compact('packages'))->layout('components.layouts.admin');
    }

    public function save()
    {
        $this->validate();

        $imagePath = null;
        if ($this->image) {
            $imagePath = $this->image->store('packages', 'public');
        }

        Package::create([
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'image' => $imagePath,
            'is_active' => $this->is_active,
        ]);

        $this->resetForm();
        $this->dispatch('packageSaved');
    }

    public function edit($id)
    {
        $package = Package::findOrFail($id);
        $this->editId = $id;
        $this->name = $package->name;
        $this->description = $package->description;
        $this->price = $package->price;
        $this->is_active = $package->is_active;
    }

    public function update()
    {
        $this->validate();

        $package = Package::findOrFail($this->editId);

        $imagePath = $package->image;
        if ($this->image) {
            $imagePath = $this->image->store('packages', 'public');
        }

        $package->update([
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'image' => $imagePath,
            'is_active' => $this->is_active,
        ]);

        $this->resetForm();
        $this->dispatch('packageUpdated');
    }

    public function delete($id)
    {
        Package::findOrFail($id)->delete();
        $this->dispatch('packageDeleted');
    }

    private function resetForm()
    {
        $this->reset(['name', 'description', 'price', 'image', 'is_active', 'editId']);
        $this->resetErrorBag();
    }
}

