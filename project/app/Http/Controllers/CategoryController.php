<?php

namespace App\Http\Controllers;

use App\Models\Category;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::paginate(5);

        return view("admin.layout.category", ["categories" => $categories]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
        ]);
        $category = Category::create($data);
        toastr()->timeOut(5000)->closeButton()->success('Category added successfully');

        return redirect()->route('admin.category.index');
    }



    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required|string',
        ]);
        $category = Category::find($id);
        $category->update($data);
        toastr()->timeOut(5000)->closeButton()->success('Category updated successfully');
        return redirect()->route('admin.category.index');
    }
    public function destroy(Category $category)
    {
        $category->delete();
        toastr()->timeOut(5000)->closeButton()->success('Category deleted successfully');
        return redirect()->route('admin.category.index');
    }
    public function showCategoryProducts(Category $category) // $id is the id of the category
    {
        $products = $category->products;
        return view('categories.products', ['products' => $products]);
    }
}
