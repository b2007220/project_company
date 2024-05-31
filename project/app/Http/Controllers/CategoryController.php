<?php

namespace App\Http\Controllers;

use App\Models\Category;

use Illuminate\Http\Request;



class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::latest()->paginate(5);
        if ($request->ajax()) {
            return view("admin.content.category-data", ["categories" => $categories])->render();
        }
        return view("admin.layout.category", ["categories" => $categories]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
        ]);

        $category = Category::create($data);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Category added successfully',
                'category' => $category
            ]);
        }

        return redirect()->back()->with('success', 'Category added successfully');
    }



    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required|string',
        ]);

        $category = Category::findOrFail($id);
        $category->update($data);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Category updated successfully',
                'category' => $category
            ]);
        }

        return redirect()->back()->with('success', 'Category updated successfully');
    }


    public function destroy(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        if ($category->delete()) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'category' => $category
                ]);
            }
            return redirect()->back()->with('success', 'Category deleted successfully');
        } else {
            if ($request->ajax()) {
                return response()->json(['success' => false]);
            }
            return redirect()->back()->with('error', 'Failed to delete category');
        }
    }
    public function showCategoryProducts(Category $category)
    {
        $products = $category->products;
        return view('categories.products', ['products' => $products]);
    }
}
