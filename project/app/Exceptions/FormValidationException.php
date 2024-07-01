<?php

namespace App\Exceptions;

use Illuminate\Support\MessageBag;
use Exception;

class FormValidationException extends Exception
{
    /**
     * @var MessageBag
     */
    protected $errors;

    /**
     * @param string $message
     * @param MessageBag $errors
     * @param int $code
     * @param \Throwable|null $previous
     */
    public function __construct($message = "", MessageBag $errors, $code = 0, \Throwable $previous = null)
    {
        $this->errors = $errors;
        parent::__construct($message, $code, $previous);
    }

    public function getErrors()
    {
        return $this->errors;
    }
}
