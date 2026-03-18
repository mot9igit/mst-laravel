<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiExceptionHandler
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Устанавливаем флаг, что запрос API, если:
        // * URL начинается с /api
        // * Заголовок Accept содержит application/json
        $isApiRequest = $request->is('api/*') ||
            $request->wantsJson() ||
            str_contains($request->header('Accept'), 'application/json');

        $request->attributes->set('is_api_request', $isApiRequest);

        return $next($request);
    }
}
