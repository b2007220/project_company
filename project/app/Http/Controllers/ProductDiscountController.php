<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Services\ProductDiscountService;
use App\Forms\ProductDiscountForm;
use App\Exceptions\FormValidationException;

class ProductDiscountController extends Controller
{
    protected $productDiscountService;
    protected $productDiscountForm;

    public function __construct(ProductDiscountService $productDiscountService, ProductDiscountForm $productDiscountForm)
    {
        $this->productDiscountService = $productDiscountService;
        $this->productDiscountForm = $productDiscountForm;
    }
    public function getDiscountedPrice(Request $request, $productId)
    {
        $discounted_price = $this->productDiscountService->getDiscountedPrice($productId);
        if (request()->ajax()) {
            return response()->json([
                'discounted_price' => $discounted_price,
            ]);
        }

        return redirect()->back();
    }

    public function store(Request $request, $id)
    {
        try {
            $productDiscountData = $this->productDiscountForm->validate($request->all());
            $newDiscountsApply = $this->productDiscountService->createNewProductDiscount($id, $productDiscountData);
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Thêm mã giảm giá thành công',
                    'newDiscounts' => $newDiscountsApply,
                ]);
            }
            return redirect()->back()->with('success', 'Thêm mã giảm giá thành công');
        } catch (FormValidationException $e) {
            return redirect()->back()->withErrors($e->getErrors())->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function removeDiscount(Request $request, $productId, $discountId)
    {
        try {
            $this->productDiscountService->removeDiscount($productId, $discountId);

            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Xóa mã giảm giá thành công',
                ]);
            }

            return redirect()->back();
        } catch (FormValidationException $e) {
            return redirect()->back()->withErrors($e->getErrors())->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function updateIsPredefined(Request $request, $productId, $discountId)
    {
        try {
            $data = $this->productDiscountService->updateIsPredefined($productId, $discountId);
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Cập nhật mã giảm giá thành công',
                    'discount' => $data['discount'],
                    'pivot_id' => $data['pivot_id'],
                    'is_predefined' => $data['is_predefined'],
                ]);
            }

            return redirect()->back();
        } catch (FormValidationException $e) {
            return redirect()->back()->withErrors($e->getErrors())->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
