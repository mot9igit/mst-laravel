<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;
class VerifyCsrfTokenMiddleware extends Middleware
{
    protected $except = [
        "api/auth/login",
    ];
}
