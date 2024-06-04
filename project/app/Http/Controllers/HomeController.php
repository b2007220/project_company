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

    public function category(Request $request)
    {
        $categories = Category::all();
        $productsQuery = Product::with(['discounts' => function ($query) {
            $query->orderBy('is_active')->orderBy('is_predefined');
        }, 'pictures']);

        if ($request->ajax()) {
            if ($request->search) {
                $productsQuery->where('name', 'like', '%' . $request->search . '%');
            }
            if ($request->sort) {
                switch ($request->sort) {
                    case 'new':
                        $productsQuery->orderBy('created_at', 'desc');
                        break;
                    case 'discount':
                        $productsQuery->whereHas('discounts', function ($query) {
                            $query->where('is_active', true);
                        });
                        break;
                    case 'price_asc':
                        $productsQuery->orderBy('price', 'asc');
                        break;
                    case 'price_desc':
                        $productsQuery->orderBy('price', 'desc');
                        break;
                }
            }
            $products = $productsQuery->paginate(9);
            return view('home.content.category-data', ['products' => $products, 'categories' => $categories])->render();
        }

        $products = $productsQuery->paginate(9);
        return view('home.layout.category', ['products' => $products, 'categories' => $categories]);
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
    }
}
