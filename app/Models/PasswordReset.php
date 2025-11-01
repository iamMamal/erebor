<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class PasswordReset extends Model
{
    protected $fillable = [
        'mobile',
        'code',
        'expires_at',
    ];

    protected $dates = ['expires_at'];

    public $timestamps = true;

    // بررسی اینکه آیا کد منقضی شده یا نه
    public function isExpired(): bool
    {
        return $this->expires_at->isPast();
    }
}
