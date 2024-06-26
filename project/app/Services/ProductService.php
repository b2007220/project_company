<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\File;

class ProductService
{
    public function getAllProducts()
    {
        return Product::with(['categories', 'discounts', 'pictures'])->orderBy('created_at', 'desc')->paginate(5);
    }
    public function loadMoreProducts($page)
    {
        return Product::paginate(3, ['*'], 'page', $page);
    }
    public function queryProducts($data)
    {
        $productsQuery = Product::with(['discounts' => function ($query) {
            $query->orderBy('is_active')->orderBy('is_predefined');
        }, 'pictures']);

        if (!empty($data['search'])) {
            $productsQuery->where('name', 'like', '%' . $data['search'] . '%');
        }
        if (!empty($data['sort'])) {
            switch ($data['sort']) {
                case 'new':
                    $productsQuery->orderBy('created_at', 'desc');
                    break;
                case 'discount':
                    $productsQuery->whereHas('discounts', function ($query) {
                        $query->where('is_active', true);
                    })->whereHas('discounts', function ($query) {
                        $query->where('is_predefined', true);
                    })->orderBy('discount', 'desc');
                    break;
                case 'priceAsc':
                    $productsQuery->orderBy('price', 'asc');
                    break;
                case 'priceDesc':
                    $productsQuery->orderBy('price', 'desc');
                    break;
            }
        }
        if (!empty($data['category'])) {
            $productsQuery->whereHas('categories', function ($query) use ($data) {
                $query->where('category_id', $data['category']);
            });
        }
        return $productsQuery->paginate(12);
    }
    public function getTopProducts()
    {
        return Product::topProducts();
    }
    public function getTopDiscountedProducts()
    {
        return Product::topDiscountedProducts();
    }
    public function getAllProductsByChunk()
    {
        return Product::with(['categories', 'discounts', 'pictures'])->orderBy('created_at', 'desc')->paginate(3);
    }
    public function createProduct($data)
    {
        $product = Product::create([
            'name' => $data['name'],
            'description' => $data['description'],
            'price' => $data['price'],
            'amount' => $data['amount'],
        ]);
        if (isset($data['images'])) {
            foreach ($data['images'] as $file) {
                $destinationPath = 'product/';
                $profileImage = date('YmdHis') . "_" . uniqid() . "." . $file->getClientOriginalExtension();
                $file->move($destinationPath, $profileImage);
                $product->pictures()->create(['link' => $profileImage]);
            }
        }
        if (isset($data['categories'])) {
            $categories = explode(',', $data['categories']);
            foreach ($categories as $category) {
                $checkCategory = Category::findOrFail($category);
                if ($checkCategory->parent_id) {
                    $product->categories()->attach($checkCategory->parent_id);
                }
                $product->categories()->attach($category);
            }
        }
        return $product;
    }
    public function updateProduct($id, $data)
    {
        $product = Product::findOrFail($id);
        if (isset($data['images'])) {
            foreach ($data['images'] as $file) {
                $destinationPath = 'product/';
                $profileImage = date('YmdHis') . "_" . uniqid() . "." . $file->getClientOriginalExtension();
                $file->move($destinationPath, $profileImage);
                $product->pictures()->create(['link' => $profileImage]);
            }
        }
        $product->name = $data['name'];
        $product->description = $data['description'];
        $product->price = $data['price'];
        $product->amount = $data['amount'];
        $product->save();

        if (isset($data['categories'])) {
            $categories = explode(',', $data['categories']);
            foreach ($categories as $category) {
                if ($product->categories->contains($category)) {
                    continue;
                }
                $checkCategory = Category::findOrFail($category);
                if ($checkCategory->parent_id) {
                    $product->categories()->attach($checkCategory->parent_id);
                }
                $product->categories()->attach($category);
            }
        }
        return $product;
    }
    public function showProductCategories(Product $product)
    {
        $categories = $product->categories;
        return $categories;
    }
    public function deleteProduct($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        if ($product->pictures) {
            foreach ($product->pictures as $picture) {
                File::delete(public_path('product/' . $picture->link));
                $picture->delete();
            }
        }
    }
    public function deleteImages($productId, $selectedPictures)
    {
        $product = Product::findOrFail($productId);
        foreach ($selectedPictures as $pictureId) {
            $picture = $product->pictures()->find($pictureId);
            if ($picture) {
                File::delete(public_path('product/' . $picture->link));
                $picture->delete();
            }
        }
    }

    public function getAvailableAmountProducts()
    {
        return Product::where('amount', '>', 0)->count();
    }
    public function getSamgeCategoryProducts(Product $product)
    {
        return Product::sameCategories($product);
    }
    public function getProductById($id)
    {
        return Product::with(['discounts' => function ($query) {
            $query->where('is_active', 1)
                ->wherePivot('is_predefined', 1);
        }, 'pictures' => function ($query2) {
            $query2->inRandomOrder()->limit(5);
        }])->find($id);
    }
}
