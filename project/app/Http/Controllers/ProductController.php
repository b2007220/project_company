<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Discount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Models\ProductPicture;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::with(['categories', 'discounts', 'pictures'])->paginate(5);
        $categories = Category::all();
        $discounts = Discount::where('type', 'PRODUCT')->get();
        if ($request->ajax()) {
            return view("admin.content.product-data", ['products' => $products, 'categories' => $categories, 'discounts' => $discounts,])->render();
        }
        return view('admin.layout.product', ['products' => $products, 'categories' => $categories, 'discounts' => $discounts,]);
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'price' => 'required|numeric',
                'amount' => 'required|numeric',
                'categories.*' => 'exists:categories,id , nullable',
            ]);
            $product = Product::create([
                'name' => $validated['name'],
                'description' => $validated['description'],
                'price' => $validated['price'],
                'amount' => $validated['amount'],
            ]);

            if ($request->categories) {
                $categories = explode(',', $request->categories);
                $product->categories()->sync($categories);
            }

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Thêm sản phẩm thành công',
                    'product' => $product,
                    'categories' => $product->categories,
                    'discounts' => $product->discounts,
                ]);
            }
            return redirect()->back()->with('success', 'Thêm sản phẩm thành công');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Thêm sản phẩm thất bại');
        }
    }
    public function storeImages(Request $request, $id)
    {
        try {
            $request->validate([
                'images' => 'required|array',
                'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);
            $product = Product::findOrFail($id);
            if (!$product) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product not found'
                ], 404);
            }

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $file) {
                    $destinationPath = 'product/';
                    $profileImage = date('YmdHis') . "_" . uniqid() . "." . $file->getClientOriginalExtension();
                    $file->move($destinationPath, $profileImage);
                    $product->pictures()->create(['link' => $profileImage]);
                }
            } else {
                error_log('Không tìm thấy file trong thông tin cung cấp');
            }

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Thêm ảnh sản phẩm thành công',
                    'pictures' => $product->pictures
                ]);
            }

            return redirect()->back()->with('success', 'Thêm ảnh sản phẩm thành công');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Thêm ảnh sản phẩm thất bại');
        }
    }


    public function update(Request $request, $id)
    {

        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'price' => 'required|numeric|min:0',
                'amount' => 'required|numeric|min:0',
                'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'categories.*' => 'exists:categories,id',
            ]);

            $product = Product::findOrFail($id);

            $product->name = $validatedData['name'];
            $product->description = $validatedData['description'];
            $product->price = $validatedData['price'];
            $product->amount = $validatedData['amount'];

            $product->save();
            $categories = explode(',', $request->categories);

            $product->categories()->sync($categories);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Cập nhật sản phẩm thành công',
                    'product' => $product,
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
        $categories = $product->categories;
        return view('admin.products.categories', ['categories' => $categories]);
    }

    public function destroy(Request $request, $id)
    {
        try {
            $product = Product::findOrFail($id);
            $product->delete();
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Xóa sản phẩm thành công',
                    'product' => $product
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

            $product = Product::findOrFail($productId);
            foreach ($request->selected_pictures as $pictureId) {
                $picture = ProductPicture::find($pictureId);
                if ($picture && $picture->product_id === $product->id) {
                    File::delete(public_path('product/' . $picture->link));
                    $picture->delete();
                }
            }

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'pictures' => $product->pictures
                ]);
            }
            return redirect()->back()->with('success', 'Xóa ảnh sản phẩm thành công');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Lỗi trong việc xóa ảnh sản phẩm');
        }
    }
}
