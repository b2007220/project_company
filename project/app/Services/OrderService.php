<?php

namespace App\Services;

use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use App\Models\Discount;
use App\Models\Cart;
use App\Models\BankAccount;
use App\Services\LocationService;


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
        $order->grand_total = $order->total - $totalDiscount * $order->total + $ship;
        $order->bank_id = $bank->id;
        $order->status = 'PENDING';
        $order->save();

        foreach ($order->products as $product) {
            $product->amount -= $product->pivot->amount;
            $product->save();
        }
        dd($order);
        return $order;
    }
    public function cancleOrder($id)
    {
        $order = Order::findOrFail($id);
        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }
        if ($order->status === 'DELIVERED' || $order->status === 'DELIVERING') {
            return response()->json(['message' => 'Không thể hủy đơn hàng đã giao hoặc đang giao'], 400);
        }
        if ($order->status === 'CANCELLED') {
            return response()->json(['message' => 'Đơn hàng đã bị hủy'], 400);
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
        foreach ($order->products as $product) {
            $total_discount = $product->discounts()->where('is_predefined', true)->sum('discount');
            if (isset(auth()->user()->productsInCart[$product->id])) {
                if (auth()->user()->productsInCart[$product->id]['amount'] += $product->pivot->amount) {
                    return response()->json(['message' => 'The amount of product is not enough'], 400);
                }
                auth()->user()->productsInCart[$product->id]['amount'] += $product->pivot->amount;
            } else {
                $cartItem = new Cart();
                $cartItem->user_id = auth()->user()->id;
                $cartItem->product_id = $product->id;
                $cartItem->amount =  $product->pivot->amount;
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
