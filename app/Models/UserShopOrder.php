<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserShopOrder extends Model
{
    use HasFactory;

    // فیلدهای قابل پر شدن
    protected $fillable = [
        'user_id',
        'products',
        'status',
        'confirmed',
    ];

    // تبدیل خودکار JSON به آرایه PHP
    protected $casts = [
        'products' => 'array',
        'confirmed' => 'boolean',
    ];

    /**
     * رابطه با کاربر
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ترجمه وضعیت به فارسی
    public function getStatusFaAttribute()
    {
        return match ($this->status) {
            'pending' => 'در انتظار بررسی',
            'confirmed' => 'تایید شده',
            'processing' => 'در حال آماده‌سازی',
            'delivered' => 'تحویل داده شده',
            default => 'نامشخص',
        };
    }


    /**
     * گرفتن محصولات از JSON به صورت collection از مدل ShopProduct
     * می‌تونه برای نمایش جزئیات محصولات استفاده بشه
     */
    public function getProductsDetailsAttribute()
    {
        $products = collect($this->products ?? []);
        return $products->map(function($item) {
            $product = \App\Models\ShopProduct::find($item['product_id']);
            if ($product) {
                return [
                    'product' => $product,
                    'quantity' => $item['quantity'],
                ];
            }
            return null;
        })->filter();
    }
}
