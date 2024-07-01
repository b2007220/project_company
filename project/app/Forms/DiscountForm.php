<?php

namespace App\Forms;

use App\Forms\BaseForm;
use Illuminate\Validation\Rule;

class DiscountForm extends BaseForm
{
    protected function rules()
    {
        return [
            'name' => 'required|string',
            'discount' => 'required|numeric',
            'amount' => 'required|numeric',
            'type' => ['required', Rule::in(['PRODUCT', 'ORDER'])],
            'expire' => 'nullable|date|after:today'
        ];
    }
}
