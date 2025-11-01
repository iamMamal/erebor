<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackageClearanceRequest extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'package_request_id', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function packageRequest()
    {
        return $this->belongsTo(PackageRequest::class);
    }

    public function package()
    {
        return $this->packageRequest->package(); // دسترسی به پکیج از طریق PackageRequest
    }

}
