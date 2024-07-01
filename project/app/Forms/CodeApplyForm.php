<?php

namespace App\Forms;

use App\Forms\BaseForm;

class CodeApplyForm extends BaseForm
{
    protected function rules()
    {
        return [
            'code' => 'required|string|exists:discounts,code',
        ];
    }
}
