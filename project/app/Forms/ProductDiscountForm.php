<?php

namespace App\Forms;

use App\Forms\BaseForm;
use Illuminate\Validation\Rule;

class ProductDiscountForm extends BaseForm
{
    protected function rules()
    {
        return [
            'productId' => 'required|exists:products,id',
            'discounts.*' => 'exists:discounts,id',
        ];
    }
}
