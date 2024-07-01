<?php

namespace App\Forms;

use App\Forms\BaseForm;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rule;
use App\Models\User;

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
            'gender' => ['nullable', Rule::in(['MAN', 'WOMAN', 'OTHER'])],
            'avatar' => ['nullable', 'image'],
            'role' => ['required', Rule::in(['USER', 'ADMIN'])]
        ];
    }
}
