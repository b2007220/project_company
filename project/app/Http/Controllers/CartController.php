<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Discount;

class CartController extends Controller
{


    public function add(Request $request)
    {
        $product = Product::findOrFail($request->product_id);
        $amount = $request->input('amount', 1);

        $cart = session()->get('cart', []);
        $total_discount = $product->discounts()->where('is_predefined', true)->sum('discount');
        if (isset($cart[$product['id']])) {
            $cart[$product['id']]['amount'] += $amount;
        } else {
            $cart[$product['id']] = [
                "name" => $product->name,
                "amount" => $amount,
                "price" => $product->price,
                "image" => $product->pictures()->first()->link,
                'predifined' =>   $total_discount,
            ];
        }

        session()->put('cart', $cart);
        return response()->json(['cart' => $cart]);
    }

    public function remove(Request $request)
    {
        $productId = $request->id;
        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            session()->put('cart', $cart);
        }

        return response()->json(['cart' => $cart]);
    }

    public function update(Request $request)
    {
        $productId = $request->id;
        $amount = (int) $request->amount;
        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            $cart[$productId]['amount'] = $amount;
            session()->put('cart', $cart);
        }

        return response()->json(['cart' => $cart]);
    }
    public function clear(Request $request)
    {
        session()->forget('cart');
        return response()->json(['cart' => []]);
    }
    public function applyDiscount(Request $request)
    {
        $cart = session()->get('cart', []);
        $discount = Discount::where('code', $request->code)->first();
        if ($discount->amount === 0 || $discount->expired_at < now()) {
            return response()->json(['message' => 'Discount code is invalid']);
        } else {
            $cart['discount'] = $discount;
        }
        return response()->json(['cart' => $cart]);
    }
}
