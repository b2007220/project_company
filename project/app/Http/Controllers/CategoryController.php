<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Exceptions\FormValidationException;
use App\Services\CategoryService;
use App\Forms\CategoryForm;

class CategoryController extends Controller
{
    protected $categoryService;

    protected $categoryForm;

    public function __construct(CategoryService $categoryService, CategoryForm $categoryForm)
    {
        $this->categoryService = $categoryService;
        $this->categoryForm = $categoryForm;
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
            $this->categoryForm->validate($request->all());
            $category = $this->categoryService->createCategory($request->all());
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
        } catch (FormValidationException $e) {
            return redirect()->back()->withErrors($e->getErrors())->withInput();
        }catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }



    public function update(Request $request, $id)
    {
        try {
            $this->categoryForm->validate($request->all());
            $category = $this->categoryService->updateCategory($id, $request->all());
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
        } catch (FormValidationException $e) {

            return redirect()->back()->withErrors($e->getErrors())->withInput();
        }catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
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
        } catch (FormValidationException $e) {

            return redirect()->back()->withErrors($e->getErrors())->withInput();
        }catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
