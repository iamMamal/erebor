<?php

namespace App\Livewire\Dashboard\Admin\Evacuation;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\PackageClearanceRequest;

class EvacuationManager extends Component
{

    use WithPagination;

    public $search = '';

    // رنگ‌ها و متن وضعیت
    public $statusColors = [
        'pending' => 'bg-yellow-200 text-yellow-800 hover:bg-yellow-300',
        'approved' => 'bg-green-200 text-green-800 hover:bg-green-300',
        'rejected' => 'bg-red-200 text-red-800 hover:bg-red-300',
    ];

    public $statusActiveColors = [
        'pending' => 'bg-yellow-500 text-white',
        'approved' => 'bg-green-500 text-white',
        'rejected' => 'bg-red-500 text-white',
    ];

    public $statusLabels = [
        'pending' => 'در انتظار',
        'approved' => 'تایید شده',
        'rejected' => 'رد شده',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updateStatus($id, $status)
    {
        $request = PackageClearanceRequest::findOrFail($id);
        $request->update(['status' => $status]);
        session()->flash('success', 'وضعیت با موفقیت بروزرسانی شد ✅');
    }

    public function render()
    {
        $requests = PackageClearanceRequest::with(['user', 'packageRequest.package'])
            ->whereHas('user', function ($q) {
                $q->where('name', 'like', "%{$this->search}%")
                    ->orWhere('mobile', 'like', "%{$this->search}%");
            })
            ->latest()
            ->paginate(10);

        return view('livewire.dashboard.admin.evacuation.evacuation-manager', compact(
            'requests'
        ))->layout('components.layouts.admin');
    }

}
