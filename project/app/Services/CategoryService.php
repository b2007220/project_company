<?php

namespace App\Services;

use App\Models\Category;

class CategoryService
{
    public function getAllCategories()
    {
        return  Category::where('parent_id', null)
            ->with('children')
            ->orderBy('created_at', 'desc')
            ->paginate(5);
    }
    public function getAllCategoriesForSelect()
    {
        return Category::with('parent', 'children')->orderBy('parent_id', 'desc')->get();
    }
    public function getAllParentCategories()
    {
        return Category::where('parent_id', null)->with('children')->get();
    }

    public function createCategory($data)
    {
        $category = Category::create([
            'name' => $data['name'],
        ]);
        $category->save();
        if ($data['categories']) {
            $children = explode(',', $data['categories']);
            if (isset($data['is_parent'])) {
                foreach ($children as $child) {
                    $checkCategory = Category::where('id', $child)->first();
                    if ($checkCategory->children()->count() > 0) {
                        foreach ($checkCategory->children as $sub) {
                            $subCategory = Category::findOrFail($sub->id);
                            $subCategory->parent_id = $category->id;
                            $subCategory->save();
                        }
                    }
                    $checkCategory->parent_id = $category->id;
                    $checkCategory->save();
                }
            } else {
                $newCategory = Category::findOrFail($children[0]);
                if ($newCategory->parent_id != null) {
                    $newCategory->parent_id = null;
                    $newCategory->save();
                }
                $category->parent_id = $children[0];
                $category->save();
                $newCategory = Category::findOrFail($children[0]);
                return $newCategory;
            }
        }
        return $category;
    }

    public function updateCategory($id, $data)
    {
        $category = Category::findOrFail($id);
        $category->name = $data['name'];
        $category->save();
        if ($data['categories']) {
            $children = explode(',', $data['categories']);
            $category->children()->update(['parent_id' => null]);
            $category->parent_id = null;
            if (isset($data['is_parent'])) {
                foreach ($children as $child) {
                    $checkCategory = Category::findOrFail($child);
                    if ($checkCategory->children()->count() > 0) {
                        foreach ($checkCategory->children as $sub) {
                            if ($sub->id === $category->id) {
                                continue;
                            } else {
                                $subCategory = Category::findOrFail($sub->id);
                                $subCategory->parent_id = $category->id;
                                $subCategory->save();
                            }
                        }
                    }
                    $checkCategory->parent_id = $category->id;
                    $checkCategory->save();
                }
            } else {
                $newCategory = Category::findOrFail($children[0]);
                if ($newCategory->parent_id != null) {
                    $newCategory->parent_id = null;
                    $newCategory->save();
                }
                $category->parent_id = $children[0];
                $category->save();
                $newCategory = Category::findOrFail($children[0]);
                return $newCategory;
            }
        }
        return $category;
    }

    public function deleteCategory($id)
    {
        $category = Category::findOrFail($id);
        $category->children()->update(['parent_id' => null]);
        return $category->delete();
    }
}
