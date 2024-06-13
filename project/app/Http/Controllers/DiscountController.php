<?php

namespace App\Http\Controllers;

use App\Models\Discount;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Carbon\Carbon;



class DiscountController extends Controller
{
    public function index(Request $request)
    {
        $discounts = Discount::paginate(5);
        if ($request->ajax()) {
            return view("admin.content.discount-data", ["discounts" => $discounts])->render();
        }
        return view("admin.layout.discount", ["discounts" => $discounts]);
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'name' => 'required|string',
                'discount' => 'required|numeric',
                'amount' => 'required|numeric',
                'type' => ['required', Rule::in(['PRODUCT', 'ORDER'])]
            ]);
            $data['expired_at'] = request('expire');
            $data['code'] = strtoupper(uniqid());
            unset($data['expire']);
            $discount = Discount::create($data);
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Thêm mã giảm giá thành công',
                    'discount' => $discount
                ]);
            }
            return redirect()->back()->with('success', 'Thêm mã giảm giá thành công');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json(['success' => false]);
            }
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
                'type' => ['required', Rule::in(['PRODUCT', 'ORDER'])]
            ]);
            if ($request->expire) {
                $data['expired_at'] = $request->expire;
            } else {
                $data['expired_at'] =  Carbon::now()->addWeeks(2);
            }

            unset($data['expire']);
            $discount = Discount::find($id);

            $discount->update($data);
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Cập nhật mã giảm giá thành công',
                    'discount' => $discount
                ]);
            }

            return redirect()->back()->with('success', 'Cập nhật mã giảm giá thành công');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json(['success' => false]);
            }
            return redirect()->back()->with('error', 'Cập nhật mã giảm giá thất bại');
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $discount = Discount::findOrFail($id);

            if ($discount->delete()) {
                if ($request->ajax()) {
                    return response()->json([
                        'success' => true,
                        'discount' => $discount
                    ]);
                }
                return redirect()->back()->with('success', 'Xóa mã giảm giá thành công');
            } else {
                if ($request->ajax()) {
                    return response()->json(['success' => false]);
                }
                return redirect()->back()->with('error', 'Xóa mã giảm giá thất bại');
            }
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json(['success' => false]);
            }
            return redirect()->back()->with('error', 'Xóa mã giảm giá thất bại');
        }
    }
}
