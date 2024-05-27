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
                $product->discounts()->attach($discount->id);
            }
            toastr()->timeOut(5000)->closeButton()->success('Mã giảm giá đã có trong sản phẩm');
        } else {
            toastr()->timeOut(5000)->closeButton()->warning('Không mã giảm giá nào được chọn');
        }

        return redirect()->route('admin.product.index');
    }
    public function removeDiscount($productId, $discountId)
    {
        $product = Product::findOrFail($productId);
        $product->discounts()->detach($discountId);

        toastr()->timeOut(5000)->closeButton()->success('Xóa mã giảm giá có trong sản phẩm thành công');

        return redirect()->route('admin.product.index');
    }
    public function updateIsPredefined(Request $request, $productId, $discountId)
    {
        $product = Product::findOrFail($productId);

        $discountIds = $product->discounts()->pluck('discounts.id')->toArray();

        $product->discounts()->updateExistingPivot($discountIds, ['is_predefined' => 0]);

        $product->discounts()->updateExistingPivot($discountId, ['is_predefined' => 1]);

        toastr()->timeOut(5000)->closeButton()->success('Áp dụng mã giảm giá thành công');

        return redirect()->route('admin.product.index');
    }
}
