<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Discount;
use App\Services\CartService;

class CartController extends Controller
{

    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }
    public function add(Request $request)
    {
        try {
            $data = $request->validate([
                'product_id' => 'required|exists:products,id',
                'amount' => 'required|integer|min:1',
            ]);
            $carts = $this->cartService->add($data);
            if ($request->ajax()) {
                return response()->json(['carts' => $carts, 'message' => 'Thêm sản phẩm vào giỏ hàng thành công']);
            }
        } catch (\Exception $e) {

            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    public function remove(Request $request)
    {
        try {
            $data = $request->validate([
                'id' => 'required|exists:products,id',
            ]);
            $carts = $this->cartService->remove($data);
            if ($request->ajax()) {
                return response()->json(['carts' => $carts, 'message' => 'Xóa sản phẩm khỏi giỏ hàng thành công']);
            }
        } catch (\Exception $e) {

            return response()->json(['message' => 'Lỗi trong việc xóa sản phẩm khỏi giỏ hàng'], 400);
        }
    }

    public function update(Request $request)
    {
        try {
            $data = $request->validate([
                'id' => 'required|exists:products,id',
                'amount' => 'required|integer|min:1',
            ]);

            if ($request->ajax()) {
                $carts = $this->cartService->update($data);
                return response()->json(['carts' => $carts, 'message' => 'Cập nhật giỏ hàng thành công']);
            }
        } catch (\Exception $e) {

            return response()->json(['message' => $e->getMessage()], 400);
        }
    }
    public function clear(Request $request)
    {
        try {
            $this->cartService->clearCart();
            if ($request->ajax()) {
                return response()->json(['message' => 'Xóa giỏ hàng thành công']);
            }
        } catch (\Exception $e) {

            return response()->json(['message' => $e->getMessage()], 400);
        }
    }
    public function applyDiscount(Request $request)
    {
        try {
            $data = $request->validate([
                'code' => 'required|exists:discounts,code',
            ]);
            $discount = $this->cartService->applyDiscount($data);

            if ($request->ajax()) {
                return response()->json(['discount' => $discount, 'message' => 'Áp dụng mã giảm giá thành công']);
            }
        } catch (\Exception $e) {

            return response()->json(['message' => $e->getMessage()], 400);
        }
    }
}
