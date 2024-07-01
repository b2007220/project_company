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
use App\Forms\ProductForm;
use App\Exceptions\FormValidationException;

class ProductController extends Controller
{
    protected $productService, $categoryService, $discountService, $productForm;

    public function __construct(ProductForm $productForm, ProductService $productService, CategoryService $categoryService, DiscountService $discountService)
    {
        $this->productService = $productService;
        $this->categoryService = $categoryService;
        $this->discountService = $discountService;
        $this->productForm = $productForm;
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
            $this->productForm->validate($request->all());
            $product = $this->productService->createProduct($request->all());
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
        } catch (FormValidationException $e) {
            return redirect()->back()->withErrors($e->getErrors())->withInput();
        }
    }


    public function update(Request $request, $id)
    {

        try {
            $this->productForm->validate($request->all());
            $product = $this->productService->updateProduct($id, $request->all());
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
        } catch (FormValidationException $e) {
            return redirect()->back()->withErrors($e->getErrors())->withInput();
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
        } catch (FormValidationException $e) {
            return redirect()->back()->withErrors($e->getErrors())->withInput();
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
        } catch (FormValidationException $e) {
            return redirect()->back()->withErrors($e->getErrors())->withInput();
        }
    }
}
