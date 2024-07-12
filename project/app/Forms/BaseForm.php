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
        $filteredData = array_intersect_key($formData, array_flip(array_keys($this->rules())));

        $this->validation = $this->validator->make($filteredData, $this->rules());

        if ($this->validation->fails()) {
            throw new FormValidationException('Validation Failed', $this->getValidationErrors());
        }

        return $filteredData;
    }

    protected function getValidationErrors()
    {
        return $this->validation->errors();
    }

    abstract protected function rules();
}
