<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Discount;
use App\Models\DiscountDetail;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['categories', 'discounts'])->get();
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
        ]);
        $product = Product::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'amount' => $validated['amount'],
        ]);

        $product->categories()->sync($validated['categories']);

        toastr()->timeOut(5000)->closeButton()->success('Product added successfully');
        return redirect()->route('admin.product.index');
    }
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'amount' => 'required|numeric|min:0',
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
        toastr()->timeOut(5000)->closeButton()->success('Product updated successfully');
        return redirect()->back();
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
}
