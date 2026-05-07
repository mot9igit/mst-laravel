<?php

namespace App\Exceptions\User;

use Exception;

class UserNotFoundByEmailException extends Exception
{
    public $message = "User with this email not found";

    public function __construct(){
        parent::__construct($this->message);
    }
}
