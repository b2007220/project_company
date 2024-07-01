<?php

namespace App\Forms;

use App\Forms\BaseForm;

class CategoryForm extends BaseForm
{
    protected function rules()
    {
        return [
            'name' => 'required|string',
            'is_parent' => 'nullable|boolean',
            'categories' => 'nullable|string',
        ];
    }
}
