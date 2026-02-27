<?php

namespace App\Exceptions;

use Exception;

class UserException extends Exception
{
    public int $status;
    public array $errors;

    public function __construct(string $message = "User Error", int $status = 400, array $errors = []){
        parent::__construct($message);

        $this->status = $status;
        $this->errors = $errors;
    }
}
