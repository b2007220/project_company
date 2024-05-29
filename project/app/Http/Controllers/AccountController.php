<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rule;

class AccountController extends Controller
{
    public function index()
    {
        $accounts = User::orderBy('role', 'desc')->paginate(10);
        return view('admin.layout.account', ['accounts' => $accounts]);
    }

    public function active(Request $request, $account)
    {
        $user = User::find($account);
        if ($user->role !== 'ADMIN') {
            $user->is_active = !$user->is_active;
            $user->save();
            toastr()->timeOut(5000)->closeButton()->success('Cập nhật trạng thái tài khoản thành công');
        } else {
            toastr()->timeOut(5000)->closeButton()->error('Không thể cập nhật trạng thái tài khoản ADMIN');
        }
        return redirect()->back();
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'phone' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'gender' => ['nullable', Rule::in(['MAN', 'WOMAN', 'OTHER'])],
            'avatar' => ['nullable', 'image'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);


        toastr()->timeOut(5000)->closeButton()->success('Thêm tài khoản thành công');
        return redirect()->back();
    }
    public function updateRole(Request $request)
    {
        $data = $request->validate([
            'role' => ['required', Rule::in(['USER', 'ADMIN'])],
        ]);
        $user = User::find($request->adjustAccountId);
        if ($user) {
            $user->role = $data['role'];
            $user->save();
            toastr()->timeOut(5000)->closeButton()->success('Đã chỉnh sửa vai trò tài khoản thành công');
        } else {
            toastr()->timeOut(5000)->closeButton()->error('Không tìm thấy tài khoản');
        }
        return redirect()->back();
    }
}
