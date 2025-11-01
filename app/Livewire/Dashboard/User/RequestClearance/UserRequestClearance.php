<?php

namespace App\Livewire\Dashboard\User\RequestClearance;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\Package;
use App\Models\PackageRequest;
use App\Models\PackageClearanceRequest;

class UserRequestClearance extends Component
{
    public $packages;
    public $userId;

    public function mount()
    {
        $user = Auth::user();
        $this->userId =  Auth()->id();
        $this->packages = PackageRequest::where('user_id', $this->userId)
            ->where('status', 'done')
            ->with(['package', 'clearanceRequest'])
            ->get();
    }

    public function requestClearance($packageRequestId)
    {
        $exists = PackageClearanceRequest::where('user_id', $this->userId)
            ->where('package_request_id', $packageRequestId)
            ->where('status', 'pending')
            ->exists();

        if ($exists) {
            session()->flash('error', 'شما قبلاً برای این پکیج درخواست تخلیه داده‌اید!');
            return redirect()->to('/dashboard/user/clearance-request');
        }

        PackageClearanceRequest::create([
            'user_id' => $this->userId,
            'package_request_id' => $packageRequestId,
            'status' => 'pending',
        ]);

        session()->flash('success', 'درخواست تخلیه شما ثبت شد ✅');
        return redirect()->to('/dashboard/user/clearance-request');
    }


public function render()
    {
        return view('livewire.dashboard.user.request-clearance.user-request-clearance')
            ->layout('components.layouts.admin');
    }
}
