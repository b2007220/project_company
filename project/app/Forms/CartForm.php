<?php

namespace App\Forms;

use App\Forms\BaseForm;

class CartForm extends BaseForm
{
    protected function rules()
    {
        return [
            'amount' => 'required|integer|min:1',
        ];
    }
}
