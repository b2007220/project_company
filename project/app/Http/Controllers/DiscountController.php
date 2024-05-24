<?php

namespace App\Http\Controllers;

use App\Models\Discount;

use Illuminate\Http\Request;



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
        ]);
        if ($request->expire != null) {
            $data['expired_at'] = request('expire');
        } else {
            $data['expired_at'] = now();
        }
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
        ]);
        if ($request->expire != null) {
            $data['expired_at'] = request('expire');
        } else {
            $data['expired_at'] = now();
        }
        unset($data['expire']);
        $discount = Discount::find($id);

        $discount->update($data);
        toastr()->timeOut(5000)->closeButton()->success('Discount updated successfully' . $discount->id);
        return redirect()->route('admin.discount.index');
    }

    public function destroy(Discount $discount)
    {
        $discount->delete();
        toastr()->timeOut(5000)->closeButton()->success('Discount deleted successfully');
        return redirect()->route('admin.discount.index');
    }
}
