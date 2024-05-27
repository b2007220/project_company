<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['discounts', 'users'])->orderBy('created_at', 'DESC')->paginate(5);
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
}
