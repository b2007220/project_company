<?php

namespace App\Forms;

use App\Forms\BaseForm;
use Illuminate\Validation\Rule;
use App\Enums\GenderStatus;

class ProfileForm extends BaseForm
{
    protected function rules()
    {
        return [
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'name' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'gender' => ['nullable', Rule::enum(GenderStatus::class)],
        ];
    }
}
