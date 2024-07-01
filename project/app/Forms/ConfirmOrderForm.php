<?php

namespace App\Forms;

use App\Forms\BaseForm;
use Illuminate\Validation\Rule;

class ConfirmOrderForm extends BaseForm
{
    protected function rules()
    {
        return [
            'receiver_name' => 'required|string',
            'address' => 'required|string',
            'payment_type' => 'required|in:CASH,TRANSFER',
            'bankName' => 'required_if:payment-type,TRANSFER',
            'bankNumber' => 'required_if:payment-type,TRANSFER',
            'id' => 'required|exists:orders,id',
            'location' => 'required|exists:locations,id',
            'phone' => 'required|string',
        ];
    }
}
