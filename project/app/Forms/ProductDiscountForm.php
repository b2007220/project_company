<?php

namespace App\Forms;

use App\Forms\BaseForm;


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
