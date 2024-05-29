<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;

class OrderController extends Controller
{
    public function index()
    {
        $newUsers = User::where('created_at', '>=', now()->subDays(7))->count();
        $totalOrders = Order::count();
        $availableProducts = Product::where('amount', '>', 0)->count();
        $orders = Order::with(['discounts', 'user'])->orderBy('created_at', 'desc')->paginate(5);
        return view('admin.layout.index', ['orders' => $orders, 'newUsers' => $newUsers, 'totalOrders' => $totalOrders, 'availableProducts' => $availableProducts]);
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
        toastr()->timeOut(5000)->closeButton()->success('Tạo đơn hàng thành công');
        return redirect()->back();
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
        return redirect()->back();
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
        toastr()->timeOut(5000)->closeButton()->success('Cập nhật đơn hàng thành công');
        return redirect()->back();
    }
}
