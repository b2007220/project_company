<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

use App\Services\CategoryService;

class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }
    public function index(Request $request)
    {
        $categories = $this->categoryService->getAllCategories();
        $allCategories = $this->categoryService->getAllCategoriesForSelect();
        if ($request->ajax()) {
            return view("admin.content.category-data", ["categories" => $categories, "allCategories" => $allCategories])->render();
        }
        return view("admin.layout.category", ["categories" => $categories, "allCategories" => $allCategories]);
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'name' => 'required|string',
                'is_parent' => 'nullable|boolean',
                'categories' => 'nullable|string',
            ]);
            $category = $this->categoryService->createCategory($data);
            $allCategories = $this->categoryService->getAllCategoriesForSelect();
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Thêm loại sản phẩm thành công',
                    'newCategory' => $category,
                    'subCategories' => $category->children ?? '',
                    'allCategories' => $allCategories
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
                'is_parent' => 'nullable|boolean',
                'categories' => 'nullable|string',
            ]);
            $category = $this->categoryService->updateCategory($id, $data);
            $allCategories = $this->categoryService->getAllCategoriesForSelect();
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Cập nhật loại sản phẩm thành công',
                    'newCategory' => $category,
                    'subCategories' => $category->children ?? '',
                    'allCategories' => $allCategories
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
            $this->categoryService->deleteCategory($id);
            $allCategories = $this->categoryService->getAllCategoriesForSelect();
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Xóa loại sản phẩm thành công',
                    'allCategories' => $allCategories
                ]);
            }
            return redirect()->back()->with('success', 'Xóa loại sản phẩm thành công');
        } catch (\Exception $e) {

            return redirect()->back()->with('error', 'Xóa loại sản phẩm thất bại');
        }
    }
}
