<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class HomeController extends Controller
{

    public function home()
    {
        $topProducts = Product::topProducts();
        $salesProducts = Product::topDiscountedProducts();
        return view('home.layout.index', ['topProducts' => $topProducts, 'salesProducts' => $salesProducts]);
    }
    public function about()
    {
        return view('home.layout.about');
    }

    public function cart()
    {
        return view('home.layout.cart');
    }

    public function category()
    {
        $categories = Category::all();
        $products = Product::with(['discounts' => function ($query) {
            $query->orderBy('is_active')
                ->orderBy('is_predefined');
        }, 'pictures'])->paginate(9);
        return view('home.layout.category', ['categories' => $categories, 'products' => $products]);
    }
    public function show($id)
    {
        $product = Product::with(['discounts' => function ($query) {
            $query->where('is_active', 1)
                ->wherePivot('is_predefined', 1);
        }, 'pictures'])->find($id);
        $products = Product::sameCategories($product);
        return view('home.layout.product', ['product' => $product, 'products' => $products]);
    }

    public function search(Request $request)
    {
        $product = Product::query()->paginate(9);
        if ($request->ajax()) {
            $product = Product::query()
                ->when($request->search, function ($query) use ($request) {
                    $query->where('name', 'like', '%' . $request->search . '%');
                })
                // ->orWhere('description', 'like', '%' . $request->search . '%');
                ->when($request->stock, function ($query) use ($request) {
                    $query->where('stock', $request->stock);
                })
                ->paginate(9);
            return view('home.content.product-data', ['products' => $product]);
        }
        return view('home.layout.search', ['products' => $product]);
    }
}
