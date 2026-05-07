<?php

namespace App\Exceptions\User;

use Exception;

class UserNotFoundByTokenException extends Exception
{
    public $message = "User with this token not found";

    public function __construct(){
        parent::__construct($this->message);
    }
}
