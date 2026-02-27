<?php

use App\Exceptions\UserException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function(UserException $e) {
            return response()->json([
                "success" => false,
                "message" => $e->getMessage(),
                "errors" => $e->errors
            ], $e->status);
        });
        $exceptions->render(function(ModelNotFoundException $e) {
            return response()->json([
                "success" => false,
                "message" => $e->getMessage() ?: "Model not found"
            ]);
        });
        $exceptions->render(function(AuthorizationException $e) {
            return response()->json([
                "success" => false,
                "message" => $e->getMessage() ?: "You don't have permission to perform this action"
            ], 403);
        });
        $exceptions->render(function(AuthenticationException $e) {
            return response()->json([
                "success" => false,
                "message" => $e->getMessage() ?: "You don't have permission to perform this action"
            ], 401);
        });
        $exceptions->render(function(ValidationException $e){
            return response()->json([
                "success" => false,
                "message" => $e->getMessage() ?: "Validation error"
            ], 422);
        });
        $exceptions->render(function(\Throwable $e){
            return response()->json([
                "success" => false,
                "message" => $e->getMessage() ?: "You don't have permission to perform this action"
            ], 500);
        });
    })->create();
