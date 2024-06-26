<?php

namespace App\Services;

use App\Models\Discount;

class DiscountService
{
    public function getAllDiscounts()
    {
        return Discount::paginate(5);
    }
    public function createDiscount($data)
    {
        $data['expired_at']  = $data['expire'];
        unset($data['expire']);
        return Discount::create($data);
    }
    public function updateDiscount($id, $data)
    {
        $discount = Discount::findOrFail($id);
        return $discount->update($data);
    }
    public function deleteDiscount($id)
    {
        $discount = Discount::findOrFail($id);
        return $discount->delete();
    }
    public function getAllProductDiscounts()
    {
        return Discount::where('type', 'PRODUCT')->get();
    }
}
