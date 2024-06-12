<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('home.layout.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        if ($request->user()->is_active) {
            $request->session()->regenerate();

            if ($request->user()->role === 'ADMIN') {
                return redirect()->intended(route('admin.order.index'));
            }

            return redirect()->intended(route('home'));
        }

        Auth::logout();
        toastr()->timeOut(5000)->closeButton()->error('Tài khoản của bạn đã bị khóa');
        return redirect()->route('login');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->intended(route('home'))->with('success', 'Logged out successfully.');
    }
}
