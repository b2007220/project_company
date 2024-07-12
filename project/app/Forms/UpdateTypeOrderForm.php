<?php

namespace App\Forms;

use App\Forms\BaseForm;
use Illuminate\Validation\Rule;
use App\Enums\OrderStatus;

class UpdateTypeOrderForm extends BaseForm
{
    protected function rules()
    {
        return [
            'status' => ['required', Rule::enum(OrderStatus::class)],
        ];
    }
}
