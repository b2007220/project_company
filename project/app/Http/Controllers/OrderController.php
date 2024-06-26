<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use App\Models\Discount;
use App\Models\BankAccount;
use App\Services\AccountService;
use Faker\Core\Number;
use App\Services\LocationService;
use App\Services\OrderService;
use App\Services\ProductService;
use App\Services\CartService;

class OrderController extends Controller
{
    protected $orderService, $userService, $productService, $locationService, $cartService;
    public function __construct(OrderService $orderService, AccountService $userService, ProductService $productService, LocationService $locationService, CartService $cartService)
    {
        $this->orderService = $orderService;
        $this->userService = $userService;
        $this->productService = $productService;
        $this->locationService = $locationService;
        $this->cartService = $cartService;
    }


    public function index(Request $request)
    {
        $newUsers = $this->userService->getNewUsers();
        $totalOrders = $this->orderService->count();
        $availableProducts = $this->productService->getAvailableAmountProducts();
        $orders = $this->orderService->getAllOrders();

        $countOrderPerDay = $this->orderService->getAmountOrdersPerDay();

        $incomePerDay = $this->orderService->getIncomePerDay();

        if ($request->ajax()) {
            return view("admin.content.order-data",  ['orders' => $orders, 'newUsers' => $newUsers, 'totalOrders' => $totalOrders, 'availableProducts' => $availableProducts, 'countOrderPerDay' => $countOrderPerDay, 'incomePerDay' => $incomePerDay])->render();
        }
        return view('admin.layout.index', ['orders' => $orders, 'newUsers' => $newUsers, 'totalOrders' => $totalOrders, 'availableProducts' => $availableProducts, 'countOrderPerDay' => $countOrderPerDay, 'incomePerDay' => $incomePerDay]);
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'total' => 'required|numeric',
                'code' => 'nullable|exists:discounts,code',
                'price' => 'required|numeric',
            ]);

            $order = $this->orderService->createOrder($data);
            if ($request->ajax()) {
                return response()->json([
                    'order' => $order,
                    'price' => $data['price'],
                    'message' => 'Tạo đơn hàng thành công',
                ]);
            }
            return redirect()->back();
        } catch (\Exception $e) {
            return response()->json(['message' => 'Lỗi trong việc tạo đơn hàng'], 400);
        }
    }

    public function checkOut(Request $request, $id)
    {
        $order = $this->orderService->getOrder($id);
        if (!$order) {
            return response()->json(['message' => 'Đơn hàng không được tìm thấy'], 404);
        }
        $locations = $this->locationService->getAllLocationForSelect();
        return view('home.layout.checkout', ['order' => $order, 'locations' => $locations]);
    }
    public function updateType(Request $request)
    {
        try {
            $data = $request->validate([
                'status' => 'required|in:PENDING,UNACCEPTED,DELIVERED,DELIVERING,CANCELLED',
                'orderId' => 'required|exists:orders,id',
            ]);
            $order = $this->orderService->updateType($data);
            if ($request->ajax()) {
                return response()->json([
                    'order' => $order,
                    'success' => 'Cập nhật trạng thái đơn hàng thành công',
                ]);
            }
            return redirect()->back();
        } catch (\Exception $e) {
            return response()->json(['message' => 'Lỗi trong việc cập nhật trạng thái đơn hàng'], 400);
        }
    }

    public function confirm(Request $request)
    {
        try {
            $data = $request->validate([
                'receiver_name' => 'required|string',
                'address' => 'required|string',
                'payment_type' => 'required|in:CASH,TRANSFER',
                'bankName' => 'required_if:payment-type,TRANSFER',
                'bankNumber' => 'required_if:payment-type,TRANSFER',
                'id' => 'required|exists:orders,id',
                'location' => 'required|exists:locations,id',
                'phone' => 'required|string',
            ]);
            $order = $this->orderService->confirmOrder($data);
            $this->cartService->clearCart();

            if ($request->ajax()) {
                return response()->json([
                    'order' => $order,
                    'success' => 'Đặt hàng thành công',
                ]);
            }
            return redirect()->back();
        } catch (\Exception $e) {
            return response()->json(['message' => 'Lỗi trong việc đặt hàng'], 400);
        }
    }
    public function cancle(Request $request, $id)
    {
        try {
            $order = $this->orderService->cancleOrder($id);
            if ($request->ajax()) {
                return response()->json([
                    'order' => $order,
                    'success' => 'Hủy đơn hàng thành công',
                ]);
            }
            return redirect()->back();
        } catch (\Exception $e) {
            return response()->json(['message' => 'Lỗi trong việc hủy đơn hàng'], 400);
        }
    }
    public function reorder(Request $request, $id)
    {
        try {
            $this->orderService->reOrder($id);
            if ($request->ajax()) {
                return response()->json([
                    'success' => 'Đặt hàng thành công',
                ]);
            }
            return redirect()->back();
        } catch (\Exception $e) {
            return response()->json(['message' => 'Lỗi trong việc đặt hàng'], 400);
        }
    }
    public function getShipFee(Request $request, $id)
    {
        if ($request->ajax()) {
            $shipFee = $this->locationService->getShipFee($id);
        }
        return response()->json(['shipFee' => $shipFee]);
    }
}
