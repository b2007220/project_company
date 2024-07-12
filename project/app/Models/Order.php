<?php

namespace App\Models;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'payment_type',
        'status',
        'address',
        'delivery_date',
        'delivered_at',
        'total',
        'grand_total',
        'receiver_name',
        'receiver_phone',
        'ship',
        'bank_id'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function bank()
    {
        return $this->belongsTo(BankAccount::class);
    }
    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_details', 'order_id', 'product_id')
            ->withPivot('amount', 'price');
    }

    public function discounts()
    {
        return $this->belongsToMany(Discount::class, 'user_select_discounts', 'order_id', 'discount_id');
    }
}
