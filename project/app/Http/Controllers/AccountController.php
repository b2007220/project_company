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
    public function index(Request $request)
    {
        $accounts = User::orderBy('role', 'desc')->paginate(10);
        if ($request->ajax()) {
            return view('admin.layout.account', ['accounts' => $accounts])->render();
        }
        return view('admin.layout.account', ['accounts' => $accounts]);
    }

    public function active(Request $request, $account)
    {
        $user = User::find($account);
        if ($user->role !== 'ADMIN') {
            $user->is_active = !$user->is_active;
            $user->save();
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'account' => $account
                ]);
            }
        } else {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                ]);
            }
            return redirect()->back()->with('error', 'Failed to activate/deactivate admin account');
        }
        return redirect()->back()->with('success', 'Account activated/deactivated successfully');
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

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'account' => $user
            ]);
        } else {
            return redirect()->back()->with('error', 'Account created falied');
        }
        return redirect()->back()->with('success', 'Account created successfully');
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
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'account' => $user
                ]);
            }
        } else {
            return redirect()->back()->with('error', 'Account role update falied');
        }
        return redirect()->back()->with('success', 'Account role update successfully');
    }
}
