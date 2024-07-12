<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Services\AccountService;
use App\Forms\ProfileForm;

class ProfileController extends Controller
{
    protected $accountService, $profileForm;

    public function __construct(AccountService $accountService, ProfileForm $profileForm)
    {
        $this->accountService = $accountService;
        $this->profileForm = $profileForm;
    }
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request)
    {
        $userData = $this->profileForm->validate($request->all());
        $user = $this->accountService->updateAccount($request->user()->id, $userData);
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Cập nhật thông tin thành công',
                'avatar' => $user->avatar,
            ]);
        }
        return redirect()->back()->with('success', 'Cập nhật thông tin thành công');
    }


    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
