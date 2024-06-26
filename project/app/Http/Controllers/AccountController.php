<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Services\AccountService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rule;
use App\Models\User;

class AccountController extends Controller
{
    protected $accountService;

    public function __construct(AccountService $accountService)
    {
        $this->accountService = $accountService;
    }

    public function index(Request $request)
    {
        $accounts = $this->accountService->getAllAccounts();
        if ($request->ajax()) {
            return view('admin.content.account-data', ['accounts' => $accounts])->render();
        }
        return view('admin.layout.account', ['accounts' => $accounts]);
    }

    public function active(Request $request, $id)
    {
        try {
            $user = $this->accountService->active($id);
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'account' => $user
                ]);
            }
            return redirect()->back()->with('success', 'Chỉnh sửa trạng thái tài khoản thành công');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Lỗi chỉnh sửa trạng thái tài khoản'
                ], 422);
            }
            return redirect()->back()->with('error', 'Lỗi chỉnh sửa trạng thái tài khoản');
        }
    }
    public function store(Request $request)
    {
        try {
            if ($request->password !== $request->password_confirmation) {
                if ($request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Mật khẩu không khớp'
                    ], 422);
                }
                return redirect()->back()->with('error', 'Mật khẩu không khớp');
            }
            $data = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
                'phone' => ['nullable', 'string', 'max:255'],
                'address' => ['nullable', 'string', 'max:255'],
                'gender' => ['nullable', Rule::in(['MAN', 'WOMAN', 'OTHER'])],
                'avatar' => ['nullable', 'image'],
                'role' => ['required', Rule::in(['USER', 'ADMIN'])]
            ]);
            $user =  $this->accountService->creteAccount($data);
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'account' => $user
                ]);
            }
            return redirect()->back()->with('success', 'Tạo tài khoản thành công');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'message' => 'Lỗi trong quá trình tạo tài khoản'
                ], 422);
            }
            return redirect()->back()->with('error', 'Lỗi trong quá trình tạo tài khoản');
        }
    }
    public function updateRole(Request $request)
    {
        try {
            $data = $request->validate([
                'role' => ['required', Rule::in(['USER', 'ADMIN'])],
                'adjustAccountId' => ['required', 'exists:' . User::class . ',id']
            ]);

            $user = $this->accountService->updateRole($data);
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'account' => $user
                ]);
            }
            return redirect()->back()->with('success', 'Cập nhật vai trò tài khoản thành công');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'message' => 'Lỗi trong quá trình cập nhật vai trò tài khoản'
                ], 422);
            }
            return redirect()->back()->with('error', 'Lỗi trong quá trình cập nhật vai trò tài khoản');
        }
    }
}
