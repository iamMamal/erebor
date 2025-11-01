<?php

namespace App\Livewire\Dashboard\Admin\Support;

use Livewire\Component;
use App\Models\Support;

class SupportManager extends Component
{
    public $instagram, $phone, $chat_link, $is_active = true;
    public $support_id = null;

    protected $rules = [
        'instagram' => 'nullable|url',
        'phone' => 'nullable|string|max:15',
        'chat_link' => 'nullable|url',
        'is_active' => 'boolean',
    ];

    public function render()
    {
        $supports = Support::latest()->get();
        return view('livewire.dashboard.admin.support.support-manager', compact('supports'))
            ->layout('components.layouts.admin');
    }

    public function save()
    {
        $this->validate();

        Support::create([
            'instagram' => $this->instagram,
            'phone' => $this->phone,
            'chat_link' => $this->chat_link,
            'is_active' => $this->is_active,
        ]);

        $this->resetForm();
        session()->flash('success', 'مورد پشتیبانی با موفقیت اضافه شد ✅');
    }

    public function edit($id)
    {
        $support = Support::findOrFail($id);
        $this->support_id = $support->id;
        $this->instagram = $support->instagram;
        $this->phone = $support->phone;
        $this->chat_link = $support->chat_link;
        $this->is_active = $support->is_active;
    }

    public function update()
    {
        $this->validate();

        $support = Support::findOrFail($this->support_id);
        $support->update([
            'instagram' => $this->instagram,
            'phone' => $this->phone,
            'chat_link' => $this->chat_link,
            'is_active' => $this->is_active,
        ]);

        $this->resetForm();
        session()->flash('success', 'مورد پشتیبانی با موفقیت ویرایش شد ✏️');
    }

    public function delete($id)
    {
        Support::findOrFail($id)->delete();
        session()->flash('success', 'مورد پشتیبانی حذف شد 🗑️');
    }

    private function resetForm()
    {
        $this->reset(['instagram', 'phone', 'chat_link', 'is_active', 'support_id']);
        $this->resetErrorBag();
    }
}
