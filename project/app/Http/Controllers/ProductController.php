<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Discount;
use App\Models\DiscountDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Models\Product_Picture;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['categories', 'discounts', 'pictures'])->paginate(5);
        $categories = Category::all();
        $discounts = Discount::where('type', 'PRODUCT')->get();
        return view('admin.layout.product', ['products' => $products, 'categories' => $categories, 'discounts' => $discounts,]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'amount' => 'required|numeric',
            'categories' => 'required|array',
            'categories.*' => 'exists:categories,id',
            'images' => 'required|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $product = Product::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'amount' => $validated['amount'],
        ]);

        $product->categories()->sync($validated['categories']);

        if ($files = $request->file('images')) {
            foreach ($files as $file) {
                $destinationPath = 'product/';
                $profileImage = date('YmdHis') . "_" . uniqid() . "." . $file->getClientOriginalExtension();
                $file->move($destinationPath, $profileImage);
                $product->pictures()->create(['link' => $profileImage]);
            }

            toastr()->timeOut(5000)->closeButton()->success('Product added successfully with images.');
        } else {
            toastr()->timeOut(5000)->closeButton()->error('No images were uploaded.');
        }

        return redirect()->route('admin.product.index');
    }

    // public function update(Request $request, $id)
    // {
    //     $validatedData = $request->validate([
    //         'name' => 'required|string|max:255',
    //         'description' => 'required|string',
    //         'price' => 'required|numeric|min:0',
    //         'amount' => 'required|numeric|min:0',
    //         'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    //     ]);

    //     $product = Product::findOrFail($id);

    //     $product->name = $validatedData['name'];
    //     $product->description = $validatedData['description'];
    //     $product->price = $validatedData['price'];
    //     $product->amount = $validatedData['amount'];

    //     $product->save();
    //     if ($request->categories) {
    //         $product->categories()->sync($request->categories);
    //     }
    //     if ($files = $request->file('images')) {
    //         foreach ($files as $file) {
    //             $destinationPath = 'public/product/';
    //             $profileImage = date('YmdHis') . "_" . uniqid() . "." . $file->getClientOriginalExtension();
    //             $file->move($destinationPath, $profileImage);

    //             $product->images()->create(['file_name' => $profileImage]);
    //         }
    //     }
    //     if ($request->has('delete_images')) {
    //         foreach ($request->delete_images as $imageId) {
    //             $image = Product_Picture::find($imageId);
    //             if ($image) {
    //                 \File::delete('public/product/' . $image->file_name);
    //                 $image->delete();
    //             }
    //         }
    //     }
    //     toastr()->timeOut(5000)->closeButton()->success('Product updated successfully');
    //     return redirect()->back();
    // }

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
    public function showProductCategories(Product $product)
    {
        $categories = $product->categories;
        return view('admin.products.categories', ['categories' => $categories]);
    }

    public function destroy(Product $product)
    {
        $product->delete();
        toastr()->timeOut(5000)->closeButton()->success('Product deleted successfully');
        return redirect()->route('admin.product.index');
    }

    // public function deleteImages(Request $request, $productId)
    // {
    //     $request->validate([
    //         'image_ids' => 'required|array',
    //         'image_ids.*' => 'exists:images,id',
    //     ]);

    //     $product = Product::findOrFail($productId);

    //     foreach ($request->image_ids as $imageId) {
    //         $image = Product_Picture::find($imageId);
    //         if ($image) {
    //             \File::delete('public/product/' . $image->file_name);
    //             $image->delete();
    //         }
    //     }

    //     return Response::json(['message' => 'Images deleted successfully']);
    // }
}
