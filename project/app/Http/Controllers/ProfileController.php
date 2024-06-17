<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProfileController extends Controller
{
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
        $validated = $request->validate([
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'gender' => 'nullable', Rule::in(['MAN', 'WOMAN', 'OTHER']),
        ]);
        $user = $request->user();
        if ($request->file('avatar')) {
            $avatar = $request->file('avatar');
            $destinationPath = 'avatar/';
            if ($user->avatar && file_exists($destinationPath . $user->avatar)) {
                unlink($destinationPath . $user->avatar);
            }
            $profileImage = date('YmdHis') . "_" . uniqid() . "." . $avatar->getClientOriginalExtension();
            $avatar->move($destinationPath, $profileImage);
            $request->user()->update(['avatar' => $profileImage]);
        } else {
            error_log('No files found in the request');
        }

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }
        $user->address = $validated['address'];
        $user->gender = $validated['gender'];
        $user->phone = $validated['phone'];
        $user->save();

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
