<?php

namespace App\Services;

use App\Models\Order;

use App\Models\Discount;
use App\Models\Cart;

use App\Services\LocationService;

use Illuminate\Support\Facades\Auth;

class OrderService
{
    public function count()
    {
        return Order::count();
    }
    public function getAllOrders()
    {
        return Order::with(['user', 'products', 'discounts'])->whereNotIn('status', ['WAIT'])->orderBy('created_at', 'desc')->paginate(5);
    }
    public function getAmountOrdersPerDay()
    {
        return Order::whereNotIn('status', ['CANCELLED', 'UNACCEPTED', 'WAIT'])
            ->selectRaw('DATE(created_at) as date, count(*) as count')
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->get();
    }
    public function getIncomePerDay()
    {
        return Order::whereNotIn('status', ['CANCELLED', 'UNACCEPTED', 'PENDING', 'WAIT'])
            ->selectRaw('DATE(created_at) as date, sum(grand_total) as total')
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->get();
    }
    public function createOrder($data)
    {
        $user = auth()->user();
        $order = Order::create([
            'user_id' =>  $user->id,
            'total' => $data['price'],
            'status' => 'WAIT',
        ]);
        $productsInCart = auth()->user()->productsInCart;
        if (isset($data['code'])) {
            $code = $data['code'];
            $discountCode = Discount::where('code', $code)->first();
            $order->discounts()->attach($discountCode, ['user_id' =>  auth()->user()->id]);
        }

        foreach ($productsInCart as $product) {
            $cart_amount = Cart::where('product_id', $product['id'])->where('user_id', auth()->user()->id)->first()->amount;
            $discountProduct = $product->discounts()->where('is_predefined', true)->sum('discount');
            $order->products()->attach($product->id, [
                'amount' =>  $cart_amount,
                'price' => $product->price - $discountProduct * $product->price / 100,
            ]);
        }
        return $order;
    }
    public function getOrder($id)
    {
        return Order::with(['user', 'products', 'discounts'])->find($id);
    }

    public function updateType($data, $id)
    {
        $order = Order::find($id);
        $order->status = $data['status'];
        if ($data['status'] === 'DELIVERED') {
            $order->delivered_at = now();
        }
        $order->save();
        return $order;
    }

    public function confirmOrder($data)
    {
        $order = Order::findOrFail($data['id']);

        $order->receiver_name = $data['receiver_name'];
        $order->address = $data['address'];
        $order->receiver_phone = $data['phone'];


        if ($data['payment_type'] === 'CASH') {
            $order->payment_type = 'CASH';
        } else {
            $order->payment_type = 'TRANSFER';
            $user = auth()->user();
            $bank = $user->bankAccounts()->firstOrCreate(
                [
                    'account_number' => $data['bankNumber'],
                    'bank_name' => $data['bankName'],
                    'user_id' => $user->id
                ]
            );
        }
        $locationService = new LocationService();
        $ship = $locationService->getShipFee($data['location']);
        $order->ship = $ship;
        $discounts = $order->discounts;
        $totalDiscount = 0;
        foreach ($discounts as $discount) {
            $totalDiscount += $discount->discount;
        }

        $order->grand_total = $order->total + $ship - $totalDiscount * $order->total / 100;
        $order->bank_id = $bank->id;
        $order->status = 'PENDING';
        $order->save();

        foreach ($order->products as $product) {
            $product->amount -= $product->pivot->amount;
            $product->save();
        }
        return $order;
    }
    public function cancleOrder($id)
    {
        $order = Order::findOrFail($id);
        if ($order->status === 'DELIVERED' || $order->status === 'DELIVERING') {
            throw new \Exception('Đơn hàng đã và đang được giao tới');
        }
        if ($order->status === 'CANCELLED') {
            throw new \Exception('Đơn hàng đã bị hủy trước đó');
        }
        $order->status = 'CANCELLED';
        $order->save();
        return $order;
    }
    public function reOrder($id)
    {
        $order = Order::findOrFail($id);
        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }
        $user = Auth::user();
        foreach ($order->products as $product) {
            $total_discount = $product->discounts()->where('is_predefined', true)->sum('discount');
            $cartProduct = Cart::where('user_id', $user->id)->where('product_id', $product->id)->first();
            if (!isset($cartProduct)) {
                $cartItem = new Cart();
                $cartItem->user_id = auth()->user()->id;
                $cartItem->product_id = $product->id;
                $cartItem->amount = 1;
                $cartItem->price = $product->price;
                $cartItem->predifined = $total_discount;
                $cartItem->link = $product->pictures()->first()->link ?? 'temp.jpg';
            }
        }
    }
    public function getAllOrderByUser()
    {
        return Order::with(
            ['discounts', 'products' => function ($query) {
                $query->with('pictures');
            }]
        )->where('user_id', auth()->user()->id)
            ->orderBy('created_at', 'desc')
            ->whereNotIn('status', ['WAIT'])
            ->paginate(5);
    }
}
