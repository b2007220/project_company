<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CartService;
use App\Forms\CartForm;
use App\Exceptions\FormValidationException;
use App\Forms\CodeApplyForm;

class CartController extends Controller
{

    protected $cartService;

    protected $cartForm;

    protected $codeApplyForm;

    public function __construct(CartService $cartService, CartForm $cartForm, CodeApplyForm $codeApplyForm)
    {
        $this->cartService = $cartService;
        $this->cartForm = $cartForm;
        $this->codeApplyForm = $codeApplyForm;
    }

    public function add(Request $request, $id)
    {
        try {
            $this->cartForm->validate($request->all());
            $carts = $this->cartService->add($id, $request->all());
            if ($request->ajax()) {
                return response()->json(['carts' => $carts, 'message' => 'Thêm sản phẩm vào giỏ hàng thành công']);
            }
        } catch (FormValidationException $e) {
            return redirect()->back()->withErrors($e->getErrors())->withInput();
        }
    }

    public function remove(Request $request, $id)
    {
        try {

            $carts = $this->cartService->remove($id);
            if ($request->ajax()) {
                return response()->json(['carts' => $carts, 'message' => 'Xóa sản phẩm khỏi giỏ hàng thành công']);
            }
        } catch (FormValidationException $e) {

            return redirect()->back()->withErrors($e->getErrors())->withInput();
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $this->cartForm->validate($request->all());
            if ($request->ajax()) {
                $carts = $this->cartService->update($id, $request->all());
                return response()->json(['carts' => $carts, 'message' => 'Cập nhật giỏ hàng thành công']);
            }
        } catch (FormValidationException $e) {

            return redirect()->back()->withErrors($e->getErrors())->withInput();
        }
    }
    public function clear(Request $request)
    {
        try {
            $this->cartService->clearCart();
            if ($request->ajax()) {
                return response()->json(['message' => 'Xóa giỏ hàng thành công']);
            }
        } catch (FormValidationException $e) {

            return redirect()->back()->withErrors($e->getErrors())->withInput();
        }
    }
    public function applyDiscount(Request $request)
    {
        try {
            $this->codeApplyForm->validate($request->all());
            $discount = $this->cartService->applyDiscount($request->all());

            if ($request->ajax()) {
                return response()->json(['discount' => $discount, 'message' => 'Áp dụng mã giảm giá thành công']);
            }
        } catch (FormValidationException $e) {

            return redirect()->back()->withErrors($e->getErrors())->withInput();
        }
    }
}
