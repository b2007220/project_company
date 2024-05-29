<?php

namespace App\Http\Controllers;

use App\Models\Discount;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;



class DiscountController extends Controller
{
    public function index()
    {
        $discounts = Discount::paginate(5);

        return view("admin.layout.discount", ["discounts" => $discounts]);
    }

    public function store(Request $request)
    {
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
        toastr()->timeOut(5000)->closeButton()->success('Discount added successfully');

        return redirect()->route('admin.discount.index');
    }



    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'discount' => 'required|numeric',
            'amount' => 'required|numeric',
            'type' => ['required', Rule::in(['PRODUCT', 'ORDER'])]
        ]);
        if ($request->expire) {
            $data['expired_at'] = now();
        } else {
            $data['expired_at'] = $request->expire;
        }

        unset($data['expire']);
        $discount = Discount::find($id);

        $discount->update($data);
        toastr()->timeOut(5000)->closeButton()->success('Discount updated successfully' . $discount->id);
        return redirect()->back();
    }

    public function destroy(Discount $discount)
    {
        $discount->delete();
        toastr()->timeOut(5000)->closeButton()->success('Discount deleted successfully');
        return redirect()->back();
    }
}
