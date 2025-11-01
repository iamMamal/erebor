<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackageRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'package_id',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }
    public function clearanceRequest()
    {
        return $this->hasOne(PackageClearanceRequest::class);
    }
}
