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
        return $this->belongsToMany(Category::class, 'product_detail', 'product_id', 'category_id');
    }
    public function pictures()
    {
        return $this->hasMany(ProductPicture::class);
    }
}
