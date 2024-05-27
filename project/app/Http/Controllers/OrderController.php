<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['discounts', 'user'])->orderBy('created_at', 'DESC')->paginate(5);
        return view('admin.layout.index', ['orders' => $orders]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|numeric',
            'total' => 'required|numeric',
        ]);

        $order = Order::create([
            'product_id' => $validated['product_id'],
            'quantity' => $validated['quantity'],
            'total' => $validated['total'],
        ]);

        return redirect()->route('orders.index')->with('success', 'Order created successfully.');
    }


    public function updateType(Request $request)
    {
        $validated = $request->validate([
            'status' => 'required|in:PENDING,UNACCEPTED,DELIVERED,DELIVERING,CANCELLED',
        ]);
        $order = Order::find($request->orderId);
        $order->status = $validated['status'];
        $order->save();
        toastr()->timeOut(5000)->closeButton()->success('Cập nhật trạng thái đơn hàng thành công');
        return redirect()->route('admin.home');
    }


    public function update(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|numeric',
            'total' => 'required|numeric',
        ]);

        $order = Order::find($request->id);
        $order->product_id = $validated['product_id'];
        $order->quantity = $validated['quantity'];
        $order->total = $validated['total'];
        $order->save();

        return redirect()->route('orders.index')->with('success', 'Order updated successfully.');
    }
}
