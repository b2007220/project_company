<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Services\AccountService;
use Illuminate\Http\Request;
use App\Exceptions\FormValidationException;
use App\Forms\AccountForm;
use App\Forms\UpdateRoleForm;


class AccountController extends Controller
{
    protected $accountService;
    protected $accountForm;
    protected $updateRoleForm;

    public function __construct(AccountService $accountService, AccountForm $accountForm, UpdateRoleForm $updateRoleForm)
    {
        $this->accountService = $accountService;
        $this->accountForm = $accountForm;
        $this->updateRoleForm = $updateRoleForm;
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
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function store(Request $request)
    {
        try {
            if ($request->password !== $request->password_confirmation) {
                if ($request->ajax()) {
                    throw new \Exception('Mật khẩu không khớp');
                }
                return redirect()->back()->with('error', 'Mật khẩu không khớp');
            }
            $this->accountForm->validate($request->all());
            $user =  $this->accountService->creteAccount($request->all());
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'account' => $user
                ]);
            }
            return redirect()->back()->with('success', 'Tạo tài khoản thành công');
        } catch (FormValidationException $e) {
            return redirect()->back()->withErrors($e->getErrors())->withInput();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    public function updateRole(Request $request)
    {
        try {
            $userData = $this->updateRoleForm->validate($request->all());
            $user = $this->accountService->updateRole($userData);
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'account' => $user
                ]);
            }
            return redirect()->back()->with('success', 'Cập nhật vai trò tài khoản thành công');
        } catch (FormValidationException $e) {
            return redirect()->back()->withErrors($e->getErrors())->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
