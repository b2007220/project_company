<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Discount;
use App\Models\DiscountDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Models\Product_Picture;
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
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'amount' => 'required|numeric',
            'categories' => 'required|array',
            'categories.*' => 'exists:categories,id',
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
        };
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Product added successfully',
                'product' => $product
            ]);
        }
        return redirect()->back()->with('success', 'Product added successfully');
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'amount' => 'required|numeric|min:0',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $product = Product::findOrFail($id);

        $product->name = $validatedData['name'];
        $product->description = $validatedData['description'];
        $product->price = $validatedData['price'];
        $product->amount = $validatedData['amount'];

        $product->save();
        if ($request->categories) {
            $product->categories()->sync($request->categories);
        }

        if ($files = $request->file('images')) {
            foreach ($files as $file) {
                $destinationPath = 'product/';
                $profileImage = date('YmdHis') . "_" . uniqid() . "." . $file->getClientOriginalExtension();
                $file->move($destinationPath, $profileImage);
                $product->images()->create(['link' => $profileImage]);
            }
        }
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Product updated successfully',
                'product' => $product
            ]);
        }
        return redirect()->back()->with('success', 'Product updated successfully');
    }

    public function showProductCategories(Product $product)
    {
        $categories = $product->categories;
        return view('admin.products.categories', ['categories' => $categories]);
    }

    public function destroy(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Product deleted successfully',
                'product' => $product
            ]);
        }
        return redirect()->back()->with('success', 'Product deleted successfully');
    }

    public function deleteImages(Request $request, $productId)
    {
        $selectedPictures = json_decode($request->input('selected_pictures'), true);

        $request->merge(['selected_pictures' => $selectedPictures])->validate([
            'selected_pictures' => 'required|array',
            'selected_pictures.*' => 'exists:product_pictures,id',
        ]);

        $product = Product::findOrFail($productId);
        foreach ($request->selected_pictures as $pictureId) {
            $picture = ProductPicture::find($pictureId);
            if ($picture && $picture->product_id == $product->id) {
                File::delete(public_path('product/' . $picture->link));
                $picture->delete();
            }
        }
        if ($product->delete()) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'product' => $product
                ]);
            }
            return redirect()->back()->with('success', 'images deleted successfully');
        } else {
            if ($request->ajax()) {
                return response()->json(['success' => false]);
            }
            return redirect()->back()->with('error', 'Failed to delete picture in product');
        }
    }
}
