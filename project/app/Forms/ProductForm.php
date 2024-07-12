<?php

namespace App\Forms;

use App\Forms\BaseForm;

class ProductForm extends BaseForm
{
    protected function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric'],
            'amount' => ['required', 'numeric'],
            'categories' => ['nullable', 'string'],
            'images' => ['nullable', 'array'],
            'images.*' => ['image', 'mimes:jpeg,png,jpg,gif', 'max:2048', 'nullable'],
        ];
    }
}
