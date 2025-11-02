<?php

namespace App\Livewire\Dashboard;

use App\Models\Support;
use Illuminate\Support\Facades\Auth;
use App\Models\Slider;
use Livewire\Component;

class Home extends Component
{
    public $userName;
    public $sliders = [];
    public $supports = []; // اضافه شد

    public function mount()
    {
        $user = Auth::user();

        // اسم کاربر برای خوش‌آمدگویی
        $this->userName = $user->name ?? 'کاربر';

        // لود اسلایدرهای فعال بر اساس ترتیب
        $this->sliders = Slider::where('is_active', true)
            ->orderBy('order', 'asc')
            ->get();

        // لود پشتیبانی‌های فعال
        $this->supports = Support::where('is_active', true)->latest()->get();
    }

    public function render()
    {

        return view('livewire.dashboard.home')->layout('components.layouts.admin');
    }
}
