<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use App\Models\SocialAccount;

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
        try {
            if ($request->authenticate()) {
                if ($request->user()) {
                    if ($request->user()->is_active) {
                        $request->session()->regenerate();

                        if ($request->user()->role === 'ADMIN') {
                            toastr()->timeOut(5000)->closeButton()->success('Đăng nhập thành công');
                            return redirect()->intended(route('admin.order.index'));
                        }
                        toastr()->timeOut(5000)->closeButton()->success('Đăng nhập thành công');
                        return redirect()->intended(route('home'));
                    }

                    Auth::logout();
                    toastr()->timeOut(5000)->closeButton()->error('Tài khoản của bạn đã bị khóa');
                    return redirect()->route('login');
                }
            } else {
                toastr()->timeOut(5000)->closeButton()->error('Tài khoản hoặc mật khẩu không đúng');
                return redirect()->route('login');
            }
        } catch (\Exception $e) {
            toastr()->timeOut(5000)->closeButton()->error('Đăng nhập thất bại');
            return redirect()->route('login');
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        try {
            Auth::guard('web')->logout();

            $request->session()->invalidate();

            $request->session()->regenerateToken();
            toastr()->timeOut(0)->closeButton()->success('Đăng xuất thành công');
            return redirect()->intended(route('home'));
        } catch (\Exception $e) {
            toastr()->timeOut(5000)->closeButton()->error('Đăng xuất thất bại');
            return redirect()->route('home');
        }
    }
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }
    public function handleProviderCallback(Request $request, $provider)
    {
        try {
            $providerUser = Socialite::driver($provider)->user();
            $account = SocialAccount::whereProvider($provider)
                ->whereProviderUserId($providerUser->id)
                ->first();
            if (!$account) {
                $account = new SocialAccount([
                    'provider_user_id' => $providerUser->id,
                    'provider' => $provider,
                ]);

                $user = User::whereEmail($providerUser->email)->first();

                if (!$user) {
                    $user = User::create([
                        'email' => $providerUser->email,
                        'name' => $providerUser->name,
                        'avatar' => $providerUser->avatar,
                    ]);
                }

                $account->user()->associate($user);
                $account->save();
            } else {
                $user = $account->user;
            }
            Auth::login($user);
            if ($user->is_active === 1 && $user->role !== null) {
                $request->session()->regenerate();
                if ($user->role === 'ADMIN' && $user->role !== null) {
                    toastr()->timeOut(5000)->closeButton()->success('Đăng nhập thành công');
                    return redirect()->intended(route('admin.order.index'));
                }
                toastr()->timeOut(5000)->closeButton()->success('Đăng nhập thành công');
                return redirect()->intended(route('home'));
            } else {
                toastr()->timeOut(5000)->closeButton()->error('Tài khoản của bạn đã bị vô hiệu hóa');
                return redirect()->intended(route('login'));
            }
        } catch (\Exception $e) {
            toastr()->timeOut(5000)->closeButton()->error('Đăng nhập thất bại');
            return redirect()->intended(route('login'));
        }
    }
}
