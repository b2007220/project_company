<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'price', 'description', 'amount'];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'product_details', 'product_id', 'category_id');
    }
    public function pictures()
    {
        return $this->hasMany(ProductPicture::class);
    }
    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_details', 'product_id', 'order_id')
            ->withPivot('amount', 'price');
    }
    public function discounts()
    {
        return $this->belongsToMany(Discount::class, 'product_discounts', 'product_id', 'discount_id')
            ->withPivot('is_predefined');
    }
}
