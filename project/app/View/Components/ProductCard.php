<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ProductCard extends Component
{
    public $productName;
    public $price;
    public $imageSrc;
    public $productLink;

    public $productDiscount;

    public function __construct($productName, $price, $imageSrc, $productLink, $productDiscount = null)
    {
        $this->productName = $productName;
        $this->price = $price;
        $this->imageSrc = $imageSrc;
        $this->productLink = $productLink;
        $this->productDiscount = $productDiscount;
    }

    public function render()
    {
        return view('components.product-card');
    }
}
