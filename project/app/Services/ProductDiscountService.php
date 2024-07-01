<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Discount;

class ProductDiscountService
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
        return $discounted_price;
    }
    public function createNewProductDiscount($id, $data)
    {
        $discounts = explode(',', $data['discounts']);
        $product = Product::findOrFail($id);
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
        return $newDiscountsApply;
    }
    public function removeDiscount($productId, $discountId)
    {
        $product = Product::findOrFail($productId);
        $product->discounts()->detach($discountId);
    }
    public function updateIsPredefined($productId, $discountId)
    {
        $product = Product::findOrFail($productId);
        $discount = Discount::findOrFail($discountId);
        $attachedDiscount = $product->discounts->find($discount->id);

        $product->discounts()->updateExistingPivot($discountId, ['is_predefined' => !$attachedDiscount->pivot->is_predefined]);
        return [
            'discount' => $discount,
            'is_predefined' => !$attachedDiscount->pivot->is_predefined,
            'pivot_id' => $attachedDiscount->pivot->id
        ];
    }
}
