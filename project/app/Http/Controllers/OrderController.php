<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use App\Models\Discount;
use App\Models\BankAccount;
use Faker\Core\Number;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $newUsers = User::where('created_at', '>=', now()->subDays(7))->count();
        $totalOrders = Order::count();
        $availableProducts = Product::where('amount', '>', 0)->count();
        $orders = Order::with(['discounts', 'user'])->orderBy('created_at', 'desc')->paginate(5);
        if ($request->ajax()) {
            return response()->json([
                'orders' => $orders,
                'totalOrders' => $totalOrders,
                'availableProducts' => $availableProducts,
                'newUsers' => $newUsers,
            ])->render();
        }
        return view('admin.layout.index', ['orders' => $orders, 'newUsers' => $newUsers, 'totalOrders' => $totalOrders, 'availableProducts' => $availableProducts]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'total' => 'required|numeric',
            'code' => 'nullable|exists:discounts,code',
            'price' => 'required|numeric',
            'ship' => 'required|numeric',
        ]);
        $total = (int)$request->total;

        $price = (int)$validated['price'];
        $ship = (int)$validated['ship'];
        $cart = session()->get('cart', []);
        $order = Order::create([
            'total_price' =>  $total,
            'user_id' => $request->user()->id,
        ]);
        if ($validated['code']) {
            $code = $validated['code'];
            $discountCode = Discount::findOrFail($code);
            $order->discounts()->attach($discountCode);
        }
        foreach ($cart as $productId => $item) {
            $discountProduct = $item['predifined'];
            $order->products()->attach($productId, [
                'amount' => $item['amount'],
                'price' => $item['price'] - $discountProduct->discount * $item['price'] / 100,
            ]);
        }
        session()->put('order', $order);
        session()->put('price', $price);
        session()->put('ship', $ship);
        if ($request->ajax()) {
            return response()->json([
                'order' => $order,
                'price' => $price,
                'ship' => $ship,
            ]);
        }
        return redirect()->back();
    }

    public function checkOut(Request $request)
    {
        return view('home.layout.checkout', ['order' => session()->get('order'), 'price' => session()->get('price'), 'ship' => session()->get('ship')]);
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
    public function confirm(Request $request)
    {
        $validated = $request->validate([
            'receiver_name' => 'required|string',
            'address' => 'required|string',
            'payment_type' => 'required|in:CASH,TRANSFER',
            'bankName' => 'required_if:payment-type,TRANSFER',
            'bankNumber' => 'required_if:payment-type,TRANSFER',
        ]);

        $order = Order::find($request->id);
        $order->receiver_name = $validated['receiver_name'];
        $order->address = $validated['address'];
        $order->total_price = $validated['total'];
        if ($validated['payment_type'] == 'CASH') {
            $order->payment_type = 'CASH';
        } else {
            $order->payment_type = 'TRANSFER';
            $bank = BankAccount::findOrFail($request->bank_id);
            if ($bank) {
                $bank = new BankAccount([
                    'bank_name' => $validated['bankName'],
                    'bank_number' => $validated['bankNumber'],
                    'user_id' => $request->user()->id,
                ]);
            }
        }
        $order->bank()->save($bank);
        session()->forget('cart');
        session()->forget('order');
        if ($request->ajax()) {
            return response()->json([
                'order' => $order,
                'success' => 'Đặt hàng thành công',
            ]);
        }
        return redirect()->back();
    }
}
