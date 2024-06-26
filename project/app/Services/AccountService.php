<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AccountService
{
    public function getAllAccounts()
    {
        return User::orderBy('role', 'desc')->paginate(10);
    }
    public function active($id)
    {
        $user = User::findOrFail($id);
        if ($user->role !== 'ADMIN') {
            $user->is_active = !$user->is_active;
            $user->save();
        }
        return $user;
    }
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return $user;
    }
    public function creteAccount($data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'role' => $data['role'],
            'password' => Hash::make($data['password']),
        ]);
        if (isset($data['phone']))  $user->phone = $data['phone'];
        if (isset($data['address']))  $user->address = $data['address'];
        if (isset($data['gender'])) $user->gender = $data['gender'];

        if (isset($data['avatar'])) {
            $image = $data['image'];
            $destinationPath = 'banner/';
            if ($user->avatar && file_exists($destinationPath . $user->avatar)) {
                unlink($destinationPath . $user->avatar);
            }
            $profileImage = date('YmdHis') . "_" . uniqid() . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $user->avatar = $profileImage;
        } else {
            if ($user->avatar == null) {
                $user->avatar = 'cat.png';
            }
        }
        $user->save();
        return $user;
    }
    public function updateRole($data)
    {
        $user = User::findOrFail($data['adjustAccountId']);
        if ($user) {
            $user->role = $data['role'];
            $user->save();
        }
        return $user;
    }
    public function updateAccount($id, $data)
    {
        $user = User::findOrFail($id);
        if (isset($data['avatar'])) {
            $avatar = $data['avatar'];
            $destinationPath = 'avatar/';
            if ($user->avatar && file_exists($destinationPath . $user->avatar)) {
                unlink($destinationPath . $user->avatar);
            }
            $profileImage = date('YmdHis') . "_" . uniqid() . "." . $avatar->getClientOriginalExtension();
            $avatar->move($destinationPath, $profileImage);
            $user->avatar = $profileImage;
        } 

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }
        $user->address = $data['address'];
        $user->gender = $data['gender'];
        $user->phone = $data['phone'];
        $user->save();
        return $user;
    }
    public function getNewUsers()
    {
        return $newUsers = User::where('created_at', '>=', now()->subDays(7))->count();
    }
}
