<?php

namespace App\Http\Controllers;

use App\Models\Discount;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use App\Services\DiscountService;
use App\Exceptions\FormValidationException;
use App\Forms\DiscountForm;

class DiscountController extends Controller
{
    protected $discountService;

    protected $discountForm;
    public function __construct(DiscountService $discountService, DiscountForm $discountForm)
    {
        $this->discountService = $discountService;
        $this->discountForm = $discountForm;
    }


    public function index(Request $request)
    {
        $discounts = $this->discountService->getAllDiscounts();

        return view("admin.layout.discount", ["discounts" => $discounts]);
    }

    public function store(Request $request)
    {
        try {
            $this->discountForm->validate($request->all());
            $data = $request->all();
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
        } catch (FormValidationException $e) {

            return redirect()->back()->withErrors($e->getErrors())->withInput();
        }
    }



    public function update(Request $request, $id)
    {
        try {
            $this->discountForm->validate($request->all());
            $data = $request->all();
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
        } catch (FormValidationException $e) {

            return redirect()->back()->withErrors($e->getErrors())->withInput();
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $this->discountService->deleteDiscount($id);
            if ($request->ajax()) {
                return response()->json(['success' => true, 'message' => 'Xóa mã giảm giá thành công']);
            }
        } catch (FormValidationException $e) {

            return redirect()->back()->withErrors($e->getErrors())->withInput();
        }
    }
}
