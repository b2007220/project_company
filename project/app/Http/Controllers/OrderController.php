<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AccountService;
use App\Services\LocationService;
use App\Services\OrderService;
use App\Services\ProductService;
use App\Services\CartService;
use App\Exceptions\FormValidationException;
use App\Forms\StoreOrderForm;
use App\Forms\UpdateTypeOrderForm;
use App\Forms\ConfirmOrderForm;

class OrderController extends Controller
{
    protected $orderService, $userService, $productService, $locationService, $cartService, $storeOrderForm, $updateTypeOrderForm, $confirmOrderForm;
    public function __construct(ConfirmOrderForm $confirmOrderForm, UpdateTypeOrderForm $updateTypeOrderForm, OrderService $orderService, AccountService $userService, ProductService $productService, LocationService $locationService, CartService $cartService, StoreOrderForm $storeOrderForm)
    {
        $this->orderService = $orderService;
        $this->userService = $userService;
        $this->productService = $productService;
        $this->locationService = $locationService;
        $this->cartService = $cartService;
        $this->storeOrderForm = $storeOrderForm;
        $this->updateTypeOrderForm = $updateTypeOrderForm;
        $this->confirmOrderForm = $confirmOrderForm;
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
            $orderData = $this->storeOrderForm->validate($request->all());
            $order = $this->orderService->createOrder($orderData);
            if ($request->ajax()) {
                return response()->json([
                    'order' => $order,
                    'message' => 'Tạo đơn hàng thành công',
                ]);
            }
            return redirect()->back();
        } catch (FormValidationException $e) {
            return redirect()->back()->withErrors($e->getErrors())->withInput();
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
    public function updateType(Request $request, $id)
    {
        try {
            $orderData = $this->updateTypeOrderForm->validate($request->all());
            $order = $this->orderService->updateType($orderData, $id);
            if ($request->ajax()) {
                return response()->json([
                    'order' => $order,
                    'success' => 'Cập nhật trạng thái đơn hàng thành công',
                ]);
            }
            return redirect()->back();
        } catch (FormValidationException $e) {
            return redirect()->back()->withErrors($e->getErrors())->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function confirm(Request $request)
    {
        try {
            $orderData = $this->confirmOrderForm->validate($request->all());
            $order = $this->orderService->confirmOrder($orderData);
            $this->cartService->clearCart();

            if ($request->ajax()) {
                return response()->json([
                    'order' => $order,
                    'success' => 'Đặt hàng thành công',
                ]);
            }
            return redirect()->back();
        } catch (FormValidationException $e) {
            return redirect()->back()->withErrors($e->getErrors())->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
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
        } catch (FormValidationException $e) {
            return redirect()->back()->withErrors($e->getErrors())->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
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
        } catch (FormValidationException $e) {
            return redirect()->back()->withErrors($e->getErrors())->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function getShipFee(Request $request, $id)
    {
        try {
            if ($request->ajax()) {
                $shipFee = $this->locationService->getShipFee($id);
            }
            return response()->json(['shipFee' => $shipFee]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
