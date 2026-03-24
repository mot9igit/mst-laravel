<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::middleware(["web", "auth"])->group(function (): void {
    Route::group(["namespace" => "App\Http\Controllers\API\Profile", "prefix" => "profile", "middleware" => []], function(){
        Route::post('/', 'UpdateController' );
        Route::get('/{user}', 'ShowController' );
    });

    Route::group(["namespace" => "App\Http\Controllers\API\Integration\Dadata", "prefix" => "suggestions", "middleware" => []], function (): void {
        Route::get("/company", "GetCompanyByInnController");
        Route::get("/address", "GetAddressController");
    });

    Route::group(["namespace" => "App\Http\Controllers\API\User", "prefix" => "users", "middleware" => []], function(){
        Route::get("/", "IndexController");
        Route::post('/', 'StoreController' );
        Route::patch("/{user}/change-password", "UpdatePasswordController");
        Route::get('/{user}', 'ShowController' );
        Route::delete("/{user}", "DeleteController");
        Route::patch("/{user}", "UpdateController");
    });
    Route::group(["namespace" => "App\Http\Controllers\API\Integration\Organization", "prefix" => "integration/organization", "middleware" => []], function(){
        Route::get("/", "IndexController");
        Route::post('/', 'StoreController' );
        // Route::get('/{organization}', 'ShowController' );
        Route::delete("/{organization}", "DeleteController");
        // Route::patch("/{organization}", "UpdateController");
    });
});


