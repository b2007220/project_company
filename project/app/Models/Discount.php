<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'discount',
        'amount',
        'expired_at',
        'is_predefined',
        'is_active',
        'code',
    ];

    public function discountDetails()
    {
        return $this->hasMany(DiscountDetail::class);
    }
    public function getAppliedToProductsAttribute()
    {
        return $this->discountDetails()->whereNotNull('product_id')->get();
    }

    public function getAppliedToOrdersAttribute()
    {
        return $this->discountDetails()->whereNotNull('order_id')->get();
    }
}
