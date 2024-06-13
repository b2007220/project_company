<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Validation\Rule;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('home.layout.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        try {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
                'phone' => ['nullable', 'string', 'max:255'],
                'address' => ['nullable', 'string', 'max:255'],
                'gender' => ['nullable', Rule::in(['MAN', 'WOMAN', 'OTHER'])],
                'avatar' => ['nullable', 'image'],
            ]);

            $defaultAvatar = 'cat.png';


            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'avatar' => $defaultAvatar,
            ]);
            event(new Registered($user));

            Auth::login($user);
            toastr()->timeOut(5000)->closeButton()->success('Đăng ký thành công');
            return redirect(route('home', absolute: false));
        } catch (\Exception $e) {
            toastr()->timeOut(5000)->closeButton()->error('Đăng ký thất bại');
            return redirect(route('register', absolute: false));
        }
    }
}
