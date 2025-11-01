<?php

namespace App\Livewire\Dashboard\Admin\PackageRequests;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\PackageRequest;

class PackageRequestManager extends Component
{
    use WithPagination;

    public $search = '';

    public $statusLabels = [
        'pending'  => 'در حال بررسی',
        'approved' => 'تأیید شده',
        'rejected' => 'رد شده',
        'done'     => 'انجام شده',
    ];


    public function render()
    {
        $requests = PackageRequest::with('user', 'package')
            ->whereHas('user', function($q) {
                $q->where('name', 'like', "%{$this->search}%")
                    ->orWhere('mobile', 'like', "%{$this->search}%");
            })
            ->latest()
            ->paginate(10);

        return view('livewire.dashboard.admin.package-requests.package-request-manager', [
            'requests' => $requests,
        ])->layout('components.layouts.admin');
    }

    public function updateStatus($id, $status)
    {
        $request = PackageRequest::findOrFail($id);
        $request->update(['status' => $status]);
        $this->dispatch('statusUpdated');
    }
}
