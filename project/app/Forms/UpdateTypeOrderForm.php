<?php

namespace App\Forms;

use App\Forms\BaseForm;
use Illuminate\Validation\Rule;

class UpdateTypeOrderForm extends BaseForm
{
    protected function rules()
    {
        return [
            'status' => 'required|in:PENDING,UNACCEPTED,DELIVERED,DELIVERING,CANCELLED',
        ];
    }
}
