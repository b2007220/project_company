<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Discount;

class ProductDiscountController extends Controller
{
    public function store(Request $request)
    {
        $product = Product::findOrFail($request->productId);
        $discountIds = $request->discount_ids;

        if (!empty($discountIds)) {
            foreach ($discountIds as $discountId) {
                $discount = Discount::findOrFail($discountId);
                if (!$product->discounts->contains($discount)) {
                    $product->discounts()->attach($discount->id);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Product not found'
                    ], 404);
                }
            }
        }
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Thêm mã giảm giá thành công',
                'discounts' => $product->discounts,
            ]);
        }
        return redirect()->back()->with('success', 'Thêm mã giảm giá thành công');
    }
    public function removeDiscount($productId, $discountId)
    {
        $product = Product::findOrFail($productId);
        $product->discounts()->detach($discountId);

        toastr()->timeOut(5000)->closeButton()->success('Xóa mã giảm giá có trong sản phẩm thành công');

        return redirect()->back();
    }
    public function updateIsPredefined(Request $request, $productId, $discountId)
    {
        $product = Product::findOrFail($productId);

        $discountIds = $product->discounts()->pluck('discounts.id')->toArray();

        $product->discounts()->updateExistingPivot($discountIds, ['is_predefined' => 0]);

        $product->discounts()->updateExistingPivot($discountId, ['is_predefined' => 1]);

        toastr()->timeOut(5000)->closeButton()->success('Áp dụng mã giảm giá thành công');

        return redirect()->back();
    }
}
