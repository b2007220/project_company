<?php

namespace App\Forms;

use App\Forms\BaseForm;
use Illuminate\Validation\Rule;

class StoreOrderForm extends BaseForm
{
    protected function rules()
    {
        return [
            'total' => ['required','numeric'],
            'code' => ['nullable','exists:discounts,code'],
            'price' => ['required','numeric'],
        ];
    }
}
