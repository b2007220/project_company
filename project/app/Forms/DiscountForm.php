<?php

namespace App\Forms;

use App\Forms\BaseForm;
use Illuminate\Validation\Rule;
use App\Enums\DiscountStatus;

class DiscountForm extends BaseForm
{
    protected function rules()
    {
        return [
            'name' => ['required', 'string'],
            'discount' => ['required', 'numeric'],
            'amount' => ['required', 'numeric'],
            'type' => ['required', Rule::enum(DiscountStatus::class)],
            'expire' => ['nullable', 'date', 'after:today']
        ];
    }
}
