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
        $searchText = $request->query('q');
        $categoryId = $request->query('category');

        $query = Product::query();

        if ($searchText) {
            $query->where('name', 'LIKE', '%' . $searchText . '%');
        }

        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        $products = $query->get();
        return response()->json(['products' => $products]);
    }
}
