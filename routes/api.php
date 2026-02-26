<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::group(["namespace" => "App\Http\Controllers\API\Profile", "prefix" => "profile", "middleware" => "web"], function(){
    Route::post('/', 'UpdateController' );
    Route::get('/{user}', 'ShowController' );
});

Route::group(["namespace" => "App\Http\Controllers\API\User", "prefix" => "users", "middleware" => "web"], function(){
    Route::get("/", "IndexController");
    Route::post('/', 'StoreController' );
    Route::delete("/{user}", "DeleteController");
    Route::patch("/{user}", "UpdateController");
});
