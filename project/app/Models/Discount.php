<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Discount extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'discount',
        'amount',
        'expired_at',
        'is_active',
        'code',
        'type',
    ];


    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_discounts', 'discount_id', 'product_id')
            ->withPivot('is_predefined', 'id');
    }
    public function orders()
    {
        return $this->belongsToMany(Order::class, 'user_select_discounts', 'discount_id', 'order_id');
    }
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_select_discounts', 'discount_id', 'user_id');
    }
    public static function expiredDiscounts()
    {
        return static::where('expired_at', '<=', Carbon::now())->get();
    }

    // public function discountDetails()
    // {
    //     return $this->hasMany(DiscountDetail::class);
    // }
    // public function getAppliedToProductsAttribute()
    // {
    //     return $this->discountDetails()->whereNotNull('product_id')->get();
    // }

    // public function getAppliedToOrdersAttribute()
    // {
    //     return $this->discountDetails()->whereNotNull('order_id')->get();
    // }
}
