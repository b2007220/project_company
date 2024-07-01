<?php
// app/Forms/BaseForm.php
namespace App\Forms;

use Illuminate\Validation\Factory as ValidatorFactory;
use Illuminate\Support\MessageBag;
use App\Exceptions\FormValidationException;

abstract class BaseForm
{
    protected $validation;
    private $validator;

    public function __construct(ValidatorFactory $validator)
    {
        $this->validator = $validator;
    }

    public function validate(array $formData)
    {
        $this->validation = $this->validator->make($formData, $this->rules());

        if ($this->validation->fails()) {
            throw new FormValidationException('Validation Failed', $this->getValidationErrors());
        }

        return true;
    }

    protected function getValidationErrors()
    {
        return $this->validation->errors();
    }

    abstract protected function rules();
}
