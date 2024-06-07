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

    public function cart(Request $request)
    {
        $cart = session()->get('cart', []);
        if ($request->ajax()) {
            return view('home.layout.cart', ['cart' => $cart])->render();
        }
        return view('home.layout.cart', ['cart' => $cart]);
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
                    case 'priceAsc':
                        $productsQuery->orderBy('price', 'asc');
                        break;
                    case 'priceDesc':
                        $productsQuery->orderBy('price', 'desc');
                        break;
                    default:
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
    public function order(Request $request)
    {
        return view('home.layout.order');
    }


    public function checkout(Request $request)
    {
        $cart = session()->get('cart', []);
        return view('home.layout.checkout', ['cart' => $cart]);
    }
}
