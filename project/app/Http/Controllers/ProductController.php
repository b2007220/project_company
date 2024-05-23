<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
    }
    public function create()
    {
        $categories = Category::all();
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'categories' => 'required|array',
            'categories.*' => 'exists:categories,id',
        ]);

        $product = Product::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price' => $validated['price'],
        ]);

        $product->categories()->sync($validated['categories']);

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
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
    public function showProductCategories(Product $product) // $id is the id of the product
    {
        $categories = $product->categories;
        return view('products.categories', ['categories' => $categories]);
    }
}
