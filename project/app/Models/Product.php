<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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
            ->withPivot('is_predefined', 'id')
            ->orderBy('is_predefined', 'desc');
    }
    public static function topProducts()
    {
        return static::select('products.*', DB::raw('SUM(order_details.amount) as total_amount'))
            ->join('order_details', 'products.id', '=', 'order_details.product_id')
            ->leftJoin('product_discounts', function ($join) {
                $join->on('products.id', '=', 'product_discounts.product_id')
                    ->where('product_discounts.is_predefined', '=', true);
            })
            ->leftJoin('product_pictures', 'products.id', '=', 'product_pictures.product_id')
            ->groupBy('products.id', 'products.name', 'products.price', 'products.description', 'products.amount', 'products.created_at', 'products.updated_at')
            ->orderByDesc('total_amount')
            ->with(['discounts' => function ($query) {
                $query->where('discounts.is_active', true)
                    ->where('product_discounts.is_predefined', true);
            }])
            ->with(['pictures' => function ($query) {
                $query->select('product_id', 'link')->first();
            }])
            ->get();
    }
    public static function topDiscountedProducts()
    {
        return static::select('products.*')
            ->join('product_discounts', 'products.id', '=', 'product_discounts.product_id')
            ->join('discounts', 'product_discounts.discount_id', '=', 'discounts.id')
            ->where('product_discounts.is_predefined', true)
            ->where('discounts.is_active', true)
            ->orderByDesc('discounts.discount')
            ->with(['pictures' => function ($query) {
                $query->select('product_id', 'link')->first();
            }])
            ->with(['discounts' => function ($query) {
                $query->where('discounts.is_active', true)
                    ->where('product_discounts.is_predefined', true);
            }])->distinct()
            ->get();
    }
    public static function sameCategories($product)
    {
        if ($product === null) {
            return collect();
        }
        $categoryIds = $product->categories()->pluck('category_id');

        return static::select('products.*')
            ->join('product_details', 'products.id', '=', 'product_details.product_id')
            ->whereIn('product_details.category_id', $categoryIds)
            ->where('products.id', '!=', $product->id)
            ->orderByDesc('products.created_at')
            ->get();
    }
}
