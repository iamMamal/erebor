<?php

namespace App\Livewire\Dashboard\Admin\Slider;


use Intervention\Image\ImageManagerStatic as Image;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Slider;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class Sliders extends Component
{
    use WithFileUploads;

    public $title;
    public $link;
    public $order = 0;
    public $is_active = true;
    public $image; // temporary upload
    public $search = '';

    public $editId = null;

    protected $rules = [
        'title' => 'nullable|string|max:255',
        'link' => 'nullable|url|max:1000',
        'order' => 'nullable|integer',
        'is_active' => 'boolean',
        'image' => 'required|image|max:2048', // max 2MB
    ];

    public function save()
    {
        $this->validate();

        // edit existing
        if ($this->editId) {
            $slider = Slider::findOrFail($this->editId);
        } else {
            $slider = new Slider();
        }

        if ($this->image) {
            // optional: delete old image
            if ($this->editId && $slider->image) {
                Storage::disk('public')->delete($slider->image);
            }

            // store original temporarily
            $path = $this->image->store('sliders', 'public');

            // resize with Intervention (مثلاً عرض 1200px)
            $fullPath = storage_path('app/public/' . $path);
            $img = Image::make($fullPath)->widen(1200, function ($constraint) {
                $constraint->upsize();
            });
            $img->save($fullPath, 85); // quality 85

            $slider->image = $path;
        }

        $slider->title = $this->title;
        $slider->link = $this->link;
        $slider->order = $this->order ?? 0;
        $slider->is_active = $this->is_active ? true : false;
        $slider->save();

        $this->resetForm();
        $this->dispatch('refreshSliders');
        session()->flash('message', 'بنر ذخیره شد');
    }

    public function edit($id)
    {
        $s = Slider::findOrFail($id);
        $this->editId = $s->id;
        $this->title = $s->title;
        $this->link = $s->link;
        $this->order = $s->order;
        $this->is_active = $s->is_active;
        // image field left empty — upload only if تغییر دادیم
    }

    public function delete($id)
    {
        $s = Slider::findOrFail($id);
        if ($s->image) {
            Storage::disk('public')->delete($s->image);
        }
        $s->delete();
        $this->dispatch('refreshSliders');
        session()->flash('message', 'بنر حذف شد');
    }

    public function resetForm()
    {
        $this->title = $this->link = null;
        $this->order = 0;
        $this->is_active = true;
        $this->image = null;
        $this->editId = null;
    }


    public function render()
    {
        $sliders = Slider::orderBy('order', 'asc')->get();

        return view('livewire.dashboard.admin.slider.sliders', compact('sliders'))->layout('components.layouts.admin');
    }
}
