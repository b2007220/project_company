<?php

namespace App\Forms;

use App\Forms\BaseForm;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rule;
use App\Models\User;
use App\Enums\GenderStatus;
use App\Enums\RoleStatus;

class AccountForm extends BaseForm
{
    protected function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'phone' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'gender' => ['nullable', Rule::enum(GenderStatus::class)],
            'avatar' => ['nullable', 'image'],
            'role' => ['required', Rule::enum(RoleStatus::class)],
        ];
    }
}
