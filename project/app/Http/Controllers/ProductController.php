<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Discount;
use Illuminate\Http\Request;
use App\Models\ProductPicture;
use App\Services\ProductService;
use App\Services\CategoryService;
use App\Services\DiscountService;

class ProductController extends Controller
{
    protected $productService, $categoryService, $discountService;

    public function __construct(ProductService $productService, CategoryService $categoryService, DiscountService $discountService)
    {
        $this->productService = $productService;
        $this->categoryService = $categoryService;
        $this->discountService = $discountService;
    }
    public function index(Request $request)
    {
        $products =   $this->productService->getAllProducts();
        $categories =   $this->categoryService->getAllCategoriesForSelect();
        $discounts =    $this->discountService->getAllProductDiscounts();
        if ($request->ajax()) {
            return view("admin.content.product-data", ['products' => $products, 'categories' => $categories, 'discounts' => $discounts,])->render();
        }
        return view('admin.layout.product', ['products' => $products, 'categories' => $categories, 'discounts' => $discounts,]);
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'price' => 'required|numeric',
                'amount' => 'required|numeric',
                'categories' => 'nullable|string',
                'images' => 'nullable|array',
                'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048|nullable',
            ]);
            $product = $this->productService->createProduct($data);
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Thêm sản phẩm thành công',
                    'product' => $product,
                    'pictures' => $product->pictures,
                    'categories' => $product->categories,
                    'discounts' => $product->discounts,
                ]);
            }
            return redirect()->back()->with('success', 'Thêm sản phẩm thành công');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Thêm sản phẩm thất bại');
        }
    }


    public function update(Request $request, $id)
    {

        try {
            $data = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'price' => 'required|numeric',
                'amount' => 'required|numeric',
                'categories' => 'string|nullable',
                'images' => 'nullable|array',
                'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048|nullable',
            ]);
            $product = $this->productService->updateProduct($id, $data);
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Cập nhật sản phẩm thành công',
                    'product' => $product,
                    'pictures' => $product->pictures,
                    'categories' => $product->categories,
                    'discounts' => $product->discounts,
                ]);
            }

            return redirect()->back()->with('success', 'Cập nhật sản phẩm thành công');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Cập nhật sản phẩm thất bại');
        }
    }


    public function showProductCategories(Product $product)
    {
        $categories = $this->productService->showProductCategories($product);
        return view('admin.products.categories', ['categories' => $categories]);
    }

    public function destroy(Request $request, $id)
    {
        try {
            $this->productService->deleteProduct($id);
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Xóa sản phẩm thành công',
                ]);
            }
            return redirect()->back()->with('success', 'Xóa sản phẩm thành công');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Xóa sản phẩm thất bại');
        }
    }

    public function deleteImages(Request $request, $productId)
    {
        try {

            $selectedPictures = json_decode($request->input('selected_pictures'), true);

            $request->merge(['selected_pictures' => $selectedPictures])->validate([
                'selected_pictures' => 'required|array',
                'selected_pictures.*' => 'exists:product_pictures,id',
            ]);
            $this->productService->deleteImages($productId, $selectedPictures);
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Xóa ảnh sản phẩm thành công',
                ]);
            }
            return redirect()->back()->with('success', 'Xóa ảnh sản phẩm thành công');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Lỗi trong việc xóa ảnh sản phẩm');
        }
    }
}
