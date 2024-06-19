<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Discount;

class CartController extends Controller
{


    public function add(Request $request)
    {
        try {
            $product = Product::findOrFail($request->product_id);
            $amount = $request->input('amount', 1);
            $cart = session()->get('cart', []);
            if ($product->amount < (int) $amount) {
                return response()->json(['message' => 'Số lượng sản phẩm không đủ'], 400);
            }
            $total_discount = $product->discounts()->where('is_predefined', true)->sum('discount');

            if (isset($cart[$product['id']])) {
                if ($product->amount < $cart[$product['id']]['amount'] +  (int)$amount) {
                    return response()->json(['message' => 'Số lượng sản phẩm không đủ'], 400);
                } else {
                    $cart[$product['id']]['amount'] += $amount;
                }
            } else {
                if ($product->pictures()->first()) {
                    $image = $product->pictures()->first()->link;
                } else {
                    $image = 'temp.jpg';
                }
                $cart[$product['id']] = [
                    "name" => $product->name,
                    "amount" => $amount,
                    "price" => $product->price,
                    "image" => $image,
                    'predifined' =>  $total_discount,
                ];
            }
            session()->put('cart', $cart);
            return response()->json(['cart' => $cart]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Số lượng sản phẩm không đủ'], 400);
        }
    }

    public function remove(Request $request)
    {
        try {
            $productId = $request->id;
            $cart = session()->get('cart', []);

            if (isset($cart[$productId])) {
                unset($cart[$productId]);
                session()->put('cart', $cart);
            }

            return response()->json(['cart' => $cart]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Lỗi trong việc xóa sản phẩm khỏi giỏ hàng'], 400);
        }
    }

    public function update(Request $request)
    {
        try {
            $productId = $request->id;
            $product = Product::findOrFail($productId);
            $amount = (int) $request->amount;
            $cart = session()->get('cart', []);

            if (isset($cart[$productId])) {
                if ($product->amount < $amount) {
                    return response()->json(['message' => 'Số lượng sản phẩm không đủ'], 400);
                }
                $cart[$productId]['amount'] = $amount;
                session()->put('cart', $cart);
            }

            return response()->json(['cart' => $cart]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Lỗi trong việc cập nhật giỏ hàng'], 400);
        }
    }
    public function clear(Request $request)
    {
        try {
            session()->forget('cart');
            return response()->json(['cart' => []]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Lỗi trong việc xóa giỏ hàng']);
        }
    }
    public function applyDiscount(Request $request)
    {
        try {
            $cart = session()->get('cart', []);
            $discount = Discount::where('code', $request->code)->first();
            if ($discount->amount === 0 || $discount->expired_at < now()) {
                return response()->json(['message' => 'Mã giảm giá không hợp lệ'], 400);
            } else {
                $cart['discount'] = $discount;
            }
            return response()->json(['cart' => $cart]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Lỗi trong việc áp dụng mã giảm giá'], 400);
        }
    }
}
