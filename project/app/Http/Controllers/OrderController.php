<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::all();
        return view('orders.index', ['orders' => $orders]);
    }
    public function create()
    {
        $products = Product::all();
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
