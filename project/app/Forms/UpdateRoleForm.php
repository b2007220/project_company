<?php

namespace App\Forms;

use App\Forms\BaseForm;
use Illuminate\Validation\Rule;

class UpdateRoleForm extends BaseForm
{
    protected function rules()
    {
        return [
            'role' => ['required', Rule::in(['USER', 'ADMIN'])],
            'adjustAccountId' => ['required', 'exists:users,id']
        ];
    }
}
