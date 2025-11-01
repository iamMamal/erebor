<?php

namespace App\Livewire\Dashboard\User\PackageRequest;

use Livewire\Component;
use App\Models\Package;
use App\Models\PackageRequest;

class UserPackageRequest extends Component
{
    public $packages;

    public function mount()
    {
        $this->packages = Package::where('is_active', true)->get();
    }

    public function requestPackage($packageId)
    {
        $userId = auth()->id();

        // بررسی آخرین درخواست کاربر برای این پکیج
        $lastRequest = PackageRequest::where('user_id', $userId)
            ->where('package_id', $packageId)
            ->latest()
            ->first();

        if ($lastRequest && $lastRequest->status === 'pending') {
            // اگر آخرین درخواست هنوز pending هست
            session()->flash('error', 'درخواست قبلی شما هنوز در حال بررسی است!');
            return redirect()->to('/dashboard/user/pkg-request');
        }

        PackageRequest::create([
            'user_id' => $userId,
            'package_id' => $packageId,
        ]);

        session()->flash('success', 'درخواست پکیچ با موفقیت ثبت شد ✅');

        return redirect('/dashboard/user/pkg-request');
    }

    public function render()
    {
        return view('livewire.dashboard.user.package-request.user-package-request')
            ->layout('components.layouts.admin');
    }
}
