<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;

use App\Services\BannerService;
use App\Services\ProductService;
use App\Services\CartService;
use App\Services\CategoryService;
use App\Services\OrderService;

class HomeController extends Controller
{
    protected $bannerService, $productService, $categoryService, $cartService, $orderService;
    public function __construct(BannerService $bannerService, ProductService $productService, CategoryService $categoryService, CartService $cartService, OrderService $orderService)
    {
        $this->bannerService = $bannerService;
        $this->productService = $productService;
        $this->categoryService = $categoryService;
        $this->cartService = $cartService;
        $this->orderService = $orderService;
    }

    public function profile()
    {
        return view('home.layout.profile');
    }
    public function home()
    {
        $banners = $this->bannerService->getRandomBanner();
        $topProducts = $this->productService->getTopProducts();
        $salesProducts = $this->productService->getTopDiscountedProducts();
        $products = $this->productService->getAllProductsByChunk();
        return view('home.layout.index', ['topProducts' => $topProducts, 'salesProducts' => $salesProducts, 'products' => $products, 'banners' => $banners]);
    }
    public function about()
    {
        return view('home.layout.about');
    }

    public function cart(Request $request)
    {
        $carts = $this->cartService->getCart();
        if ($request->ajax()) {
            return view('home.layout.cart', ['carts' => $carts])->render();
        }
        return view('home.layout.cart', ['carts' => $carts]);
    }

    public function category(Request $request)
    {
        $data = [
            'search' => $request->search,
            'sort' => $request->sort,
            'category' => $request->category
        ];
        $categories = $this->categoryService->getAllParentCategories();
        $products = $this->productService->queryProducts($data);

        if ($request->ajax()) {
            return view('home.content.category-data', ['products' => $products, 'categories' => $categories])->render();
        }

        return view('home.layout.category', ['products' => $products, 'categories' => $categories]);
    }

    public function loadMore(Request $request)
    {
        if ($request->ajax()) {
            $page = $request->input('page', 1);
            $products = $this->productService->loadMoreProducts($page);
            return view('home.content.extraproduct-data', ['products' => $products])->render();
        }
    }

    public function show($id)
    {
        $product = $this->productService->getProductById($id);
        $products = $this->productService->getSamgeCategoryProducts($product);
        return view('home.layout.product', ['product' => $product, 'products' => $products]);
    }
    public function order(Request $request)

    {
        $orders = $this->orderService->getAllOrderByUser();
        foreach ($orders as $order) {
            $order->products = $order->products()->get();
        }   
        if ($request->ajax()) {
            return view('home.content.order-data', ['orders' => $orders]);
        }
        return view('home.layout.order', ['orders' => $orders]);
    }
}
