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
        try {
            $data = $request->validate([
                'name' => 'required|string',
            ]);

            $category = Category::create($data);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Thêm loại sản phẩm thành công',
                    'category' => $category
                ]);
            }

            return redirect()->back()->with('success', 'Thêm loại sản phẩm thành công');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Thêm loại sản phẩm thất bại');
        }
    }



    public function update(Request $request, $id)
    {
        try {
            $data = $request->validate([
                'name' => 'required|string',
            ]);

            $category = Category::findOrFail($id);
            $category->update($data);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Cập nhật loại sản phẩm thành công',
                    'category' => $category
                ]);
            }

            return redirect()->back()->with('success', 'Cập nhật loại sản phẩm thành công');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Cập nhật loại sản phẩm thất bại');
        }
    }


    public function destroy(Request $request, $id)
    {
        try {
            $category = Category::findOrFail($id);

            if ($category->delete()) {
                if ($request->ajax()) {
                    return response()->json([
                        'success' => true,
                        'category' => $category
                    ]);
                }
                return redirect()->back()->with('success', 'Xóa loại sản phẩm thành công');
            } else {
                if ($request->ajax()) {
                    return response()->json(['success' => false]);
                }
                return redirect()->back()->with('error', 'Xóa loại sản phẩm thất bại');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Xóa loại sản phẩm thất bại');
        }
    }
    public function showCategoryProducts(Category $category)
    {
        $products = $category->products;
        return view('categories.products', ['products' => $products]);
    }
}
