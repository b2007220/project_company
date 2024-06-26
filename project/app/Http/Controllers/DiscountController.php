<?php

namespace App\Http\Controllers;

use App\Models\Discount;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use App\Services\DiscountService;


class DiscountController extends Controller
{
    protected $discountService;
    public function __construct(DiscountService $discountService)
    {
        $this->discountService = $discountService;
    }


    public function index(Request $request)
    {
        $discounts = $this->discountService->getAllDiscounts();

        return view("admin.layout.discount", ["discounts" => $discounts]);
    }

    public function store(Request $request)
    {
        try {

            $data = $request->validate([
                'name' => 'required|string',
                'discount' => 'required|numeric',
                'amount' => 'required|numeric',
                'type' => ['required', Rule::in(['PRODUCT', 'ORDER'])],
                'expire' => 'nullable|date|after:today'
            ]);
            $data['code'] = strtoupper(uniqid());
            $discount = $this->discountService->createDiscount($data);
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Thêm mã giảm giá thành công',
                    'discount' => $discount
                ]);
            }
            return redirect()->back()->with('success', 'Thêm mã giảm giá thành công');
        } catch (\Exception $e) {

            return redirect()->back()->with('error', 'Thêm mã giảm giá thất bại');
        }
    }



    public function update(Request $request, $id)
    {
        try {
            $data = $request->validate([
                'name' => 'required|string',
                'discount' => 'required|numeric',
                'amount' => 'required|numeric',
                'type' => ['required', Rule::in(['PRODUCT', 'ORDER'])],
                'expire' => 'nullable|date|after:today',
            ]);
            if ($request->expire) {
                unset($data['expire']);
                $data['expired_at'] = $request->expire;
            } else {
                $data['expired_at'] =  Carbon::now()->addWeeks(2);
            }

            $discount = $this->discountService->updateDiscount($id, $data);
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Cập nhật mã giảm giá thành công',
                    'discount' => $discount
                ]);
            }
            return redirect()->back()->with('success', 'Cập nhật mã giảm giá thành công');
        } catch (\Exception $e) {

            return redirect()->back()->with('error', 'Cập nhật mã giảm giá thất bại');
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $this->discountService->deleteDiscount($id);
            if ($request->ajax()) {
                return response()->json(['success' => true, 'message' => 'Xóa mã giảm giá thành công']);
            }
        } catch (\Exception $e) {

            return redirect()->back()->with('error', 'Xóa mã giảm giá thất bại');
        }
    }
}
