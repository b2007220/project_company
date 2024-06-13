<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;

class HomeController extends Controller
{
    public function profile()
    {
        return view('home.layout.profile');
    }
    public function home()
    {
        $topProducts = Product::topProducts();
        $salesProducts = Product::topDiscountedProducts();
        $products = Product::paginate(3);
        return view('home.layout.index', ['topProducts' => $topProducts, 'salesProducts' => $salesProducts, 'products' => $products]);
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
        $categories = Category::paginate(6);
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
            if ($request->category) {
                $productsQuery->whereHas('categories', function ($query) use ($request) {
                    $query->where('category_id', $request->category);
                });
            }
            $products = $productsQuery->paginate(9);
            return view('home.content.category-data', ['products' => $products, 'categories' => $categories])->render();
        }

        $products = $productsQuery->paginate(9);
        return view('home.layout.category', ['products' => $products, 'categories' => $categories]);
    }
    public function loadMore(Request $request)
    {
        if ($request->ajax()) {
            $page = $request->input('page', 1);
            $products = Product::paginate(3, ['*'], 'page', $page);
            return view('home.content.extraproduct-data', ['products' => $products])->render();
        }
    }

    public function show($id)
    {
        $product = Product::with(['discounts' => function ($query) {
            $query->where('is_active', 1)
                ->wherePivot('is_predefined', 1);
        }, 'pictures' => function ($query2) {
            $query2->inRandomOrder()->limit(5);
        }])->find($id);
        $products = Product::sameCategories($product);
        return view('home.layout.product', ['product' => $product, 'products' => $products]);
    }
    public function order(Request $request)
    {
        $orders = Order::with(['discounts', 'products' => function ($query) {
            $query->with('pictures');
        }])->orderBy('created_at', 'desc')->paginate(5);
        if ($request->ajax()) {
            return view('home.content.order-data', ['orders' => $orders]);
        }
        return view('home.layout.order', ['orders' => $orders]);
    }
}
