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
            $cartDatas = $this->cartForm->validate($request->all());
            $carts = $this->cartService->add($id, $cartDatas);
            if ($request->ajax()) {
                return response()->json(['carts' => $carts, 'message' => 'Thêm sản phẩm vào giỏ hàng thành công']);
            }
        } catch (FormValidationException $e) {
            return redirect()->back()->withErrors($e->getErrors())->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
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
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $cartDatas = $this->cartForm->validate($request->all());
            if ($request->ajax()) {
                $carts = $this->cartService->update($id, $cartDatas);
                return response()->json(['carts' => $carts, 'message' => 'Cập nhật giỏ hàng thành công']);
            }
        } catch (FormValidationException $e) {

            return redirect()->back()->withErrors($e->getErrors())->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
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
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function applyDiscount(Request $request)
    {
        try {
            $codeData = $this->codeApplyForm->validate($request->all());
            $discount = $this->cartService->applyDiscount($codeData);

            if ($request->ajax()) {
                return response()->json(['discount' => $discount, 'message' => 'Áp dụng mã giảm giá thành công']);
            }
        } catch (FormValidationException $e) {

            return redirect()->back()->withErrors($e->getErrors())->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
