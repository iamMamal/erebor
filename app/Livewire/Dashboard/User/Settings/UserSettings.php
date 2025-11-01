<?php

namespace App\Livewire\Dashboard\User\Settings;

use Livewire\Attributes\On;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class UserSettings extends Component
{
    public $name;
    public $address;
    public $latitude;
    public $longitude;
    public $successMessage;

    public function mount()
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->address = $user->address;
    }

    #[On('locationSelected')]
    public function setLocation($lat, $lng, $address)
    {
        $this->latitude = $lat;
        $this->longitude = $lng;
        $this->address = $address;
    }

    public function update()
    {
        $this->validate([
            'name' => 'required|string|min:3|max:50',
            'address' => 'required|string|max:255',
        ], [
            'address.required' => 'لطفاً آدرس خود را از روی نقشه انتخاب کنید.',
        ]);

        // ✅ چک اینکه حتماً مختصات تنظیم شده باشه
        if (!$this->latitude || !$this->longitude) {
            $this->addError('address', 'لطفاً ابتدا روی نقشه کلیک کنید تا موقعیت شما مشخص شود.');
            return;
        }

        // ✅ چک اینکه داخل سبزوار باشه
        if (!str_contains($this->address, 'سبزوار')) {
            $this->addError('address', 'آدرس باید در محدوده شهر سبزوار باشد.');
            return;
        }

        $user = Auth::user();

        $user->update([
            'name' => $this->name,
            'address' => $this->address,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
        ]);

        $this->successMessage = 'تغییرات با موفقیت ذخیره شد ✅';
    }


    public function render()
    {
        return view('livewire.dashboard.user.settings.user-settings')
            ->layout('components.layouts.admin');
    }
}
