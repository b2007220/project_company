<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Discount;

class ProductDiscountController extends Controller
{
    public function getDiscountedPrice($productId)
    {
        $product = Product::findOrFail($productId);
        $total_discount = 0;

        if ($product->discounts->count() > 0) {
            foreach ($product->discounts as $discount) {
                if ($discount->pivot->is_predefined) {
                    $total_discount += $discount->discount;
                }
            }
        }

        $discounted_price = $product->price - ($product->price * $total_discount) / 100;

        if (request()->ajax()) {
            return response()->json([
                'discounted_price' => $discounted_price,
            ]);
        }

        return redirect()->back();
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'productId' => 'required|exists:products,id',
                'discounts.*' => 'exists:discounts,id',
            ]);
            $discounts = explode(',', $request->discounts);
            $product = Product::findOrFail($request->productId);
            $newDiscountsApply = [];
            if (!empty($discounts)) {
                foreach ($discounts as $discountId) {
                    $discount = Discount::findOrFail($discountId);
                    if (!$product->discounts->contains($discount) && $discount->is_active) {
                        $product->discounts()->attach($discount->id);
                        $product->load('discounts');
                        $attachedDiscount = $product->discounts->find($discount->id);
                        if ($attachedDiscount) {
                            $newDiscountsApply[] = [
                                'discount' => $attachedDiscount,
                                'pivot_id' => $attachedDiscount->pivot->id,
                                'is_predefined' => $attachedDiscount->pivot->is_predefined,
                            ];
                        }
                    } else {
                        continue;
                    }
                }
            }
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Thêm mã giảm giá thành công',
                    'newDiscounts' => $newDiscountsApply,
                ]);
            }
            return redirect()->back()->with('success', 'Thêm mã giảm giá thành công');
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Thêm mã giảm giá thất bại',
                'error' => $e->getMessage(),
            ]);
        }
    }
    public function removeDiscount($productId, $discountId)
    {
        try {
            $product = Product::findOrFail($productId);
            $product->discounts()->detach($discountId);

            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Xóa mã giảm giá thành công',
                ]);
            }

            return redirect()->back();
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Xóa mã giảm giá thất bại',
                'error' => $e->getMessage(),
            ]);
        }
    }
    public function updateIsPredefined(Request $request, $productId, $discountId)
    {
        try {
            $product = Product::findOrFail($productId);
            $discount = Discount::findOrFail($discountId);
            $attachedDiscount = $product->discounts->find($discount->id);

            $product->discounts()->updateExistingPivot($discountId, ['is_predefined' => !$attachedDiscount->pivot->is_predefined]);


            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Cập nhật mã giảm giá thành công',
                    'discount' => $discount,
                    'pivot_id' => $attachedDiscount->pivot->id,
                    'is_predefined' => !$attachedDiscount->pivot->is_predefined,
                ]);
            }

            return redirect()->back();
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Cập nhật mã giảm giá thất bại',
                'error' => $e->getMessage(),
            ]);
        }
    }
}
