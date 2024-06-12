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

    public function active(Request $request, $id)
    {
        $user = User::find($id);
        if ($user->role !== 'ADMIN') {
            $user->is_active = !$user->is_active;
            $user->save();
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'account' => $user
                ]);
            }
        } else {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'account' => $user
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
        if ($request->password !== $request->password_confirmation) {
            return redirect()->back()->with('error', 'Password confirmation does not match');
        }
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);
        if ($request->phone) {
            $user->phone = $request->phone;
        }
        if ($request->address) {
            $user->address = $request->address;
        }
        if ($request->gender) {
            $user->gender = $request->gender;
        }
        if ($request->hasFile('avatar')) {
            $user->avatar = $request->file('avatar')->store('avatars');
        } else {
            $user->avatar = 'cat.png';
        }
        $user->save();
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
