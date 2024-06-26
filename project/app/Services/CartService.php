<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use App\Models\Discount;

class CartService
{
    public function getCart()
    {
        $user = Auth::user();
        $carts = $user->carts;
        return $carts;
    }
    public function add($data)
    {
        $product = Product::findOrFail($data['product_id']);
        $amount = $data['amount'] ?? 1;
        $user = Auth::user();
        if ($product->amount < $amount) {
            throw new \Exception('Số lượng sản phẩm không đủ');
        }
        $total_discount = $product->discounts()->where('is_predefined', true)->sum('discount');

        $cartProduct = Cart::where('user_id', $user->id)->where('product_id', $data['product_id'])->first();
        if (isset($cartProduct)) {
            if ($cartProduct->amount + $amount > $product->amount) {
                throw new \Exception('Số lượng sản phẩm không đủ');
            } else {
                $cartProduct->amount += $amount;
                $cartProduct->save();
            }
        } else {
            $cartItem = new Cart();
            $cartItem->user_id = $user->id;
            $cartItem->product_id = $product->id;
            $cartItem->amount = (int)$amount;
            $cartItem->price = $product->price;
            $cartItem->predifined = $total_discount;
            $cartItem->link = $product->pictures()->first()->link ?? 'temp.jpg';
            $cartItem->save();
        }
        $carts = $user->carts;
        return $carts;
    }
    public function remove($data)
    {
        $productId = $data['id'];
        $user = Auth::user();
        $cartItem = Cart::where('user_id', $user->id)->where('product_id', $productId)->first();
        if ($cartItem) {
            $cartItem->delete();
        }
        $carts = $user->carts;
        return $carts;
    }

    public function update($data)
    {
        $productId = $data['id'];
        $product = Product::findOrFail($productId);
        $amount =  $data['amount'];
        $user = Auth::user();
        $cartItem = Cart::where('user_id', $user->id)->where('product_id', $productId)->first();
        if ($cartItem) {
            if ($product->amount < (int)$amount) {
                throw new \Exception('Số lượng sản phẩm không đủ');
            } else {
                $cartItem->amount = $amount;
                $cartItem->save();
            }
        }
        $carts = $user->carts;
        return $carts;
    }
    public function clearCart()
    {
        $user = Auth::user();
        $user->carts()->delete();
    }

    public function applyDiscount($data)
    {

        $discount = Discount::where('code', $data['code'])->first();
        if ($discount->amount <= 0 || $discount->expired_at < now() || $discount->is_active === false || $discount->type === 'PRODUCT') {
            throw new \Exception('Mã giảm giá không hợp lệ');
        } else {
            return $discount;
        }
    }
}
