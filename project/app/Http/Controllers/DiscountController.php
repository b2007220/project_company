<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
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

        if ($request->ajax()) {
            return view("admin.content.discount-data", ['discounts' => $discounts])->render();
        }
        return view("admin.layout.discount", ["discounts" => $discounts]);
    }

    public function store(Request $request)
    {
        try {
            $discountData = $this->discountForm->validate($request->all());

            $discountData['code'] = strtoupper(uniqid());
            $discount = $this->discountService->createDiscount($discountData);
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
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }



    public function update(Request $request, $id)
    {
        try {
            $discountData = $this->discountForm->validate($request->all());

            if ($request->expire) {
                unset($discountData['expire']);
                $discountData['expired_at'] = $request->expire;
            } else {
                $discountData['expired_at'] =  Carbon::now()->addWeeks(2);
            }

            $discount = $this->discountService->updateDiscount($id, $discountData);
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
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
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
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
