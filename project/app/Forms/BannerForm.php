<?php

namespace App\Forms;

use App\Forms\BaseForm;

class BannerForm extends BaseForm
{
    protected function rules()
    {
        return [
            'link' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }
}
