<?php

use App\Http\Controllers\API\Files\UploadController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::middleware(["web", "auth"])->group(function (): void {

    Route::post('/upload', UploadController::class)->middleware([]);

    Route::group(["namespace" => "App\Http\Controllers\API\Profile", "prefix" => "profile", "middleware" => []], function(){
        Route::post('/', 'UpdateController' );
        Route::get('/{user}', 'ShowController' );
    });

    Route::group(["namespace" => "App\Http\Controllers\API\System\Geo\Country", "prefix" => "system/geo/country", "middleware" => []], function(){
        Route::get("/", "IndexController");
        Route::post('/', 'StoreController' );
        Route::get('/{country}', 'ShowController' );
        Route::delete("/{country}", "DeleteController");
        Route::patch("/{country}", "UpdateController");
    });

    Route::group(["namespace" => "App\Http\Controllers\API\System\Geo\City", "prefix" => "system/geo/city", "middleware" => []], function(){
        Route::get("/", "IndexController");
        Route::post('/', 'StoreController' );
        Route::get('/{city}', 'ShowController' );
        Route::delete("/{city}", "DeleteController");
        Route::patch("/{city}", "UpdateController");
    });

    Route::group(["namespace" => "App\Http\Controllers\API\System\Geo\Region", "prefix" => "system/geo/region", "middleware" => []], function(){
        Route::get("/", "IndexController");
        Route::post('/', 'StoreController' );
        Route::get('/{city}', 'ShowController' );
        Route::delete("/{city}", "DeleteController");
        Route::patch("/{city}", "UpdateController");
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
        Route::get('/{organization}', 'ShowController' );
        Route::delete("/{organization}", "DeleteController");
        Route::patch("/{organization}", "UpdateController");
        Route::get('/{organization}/user', 'User\IndexController' );
        Route::post('/{organization}/user', 'User\StoreController' );
        Route::delete('/{organization}/user/{user}', 'User\DeleteController' );
        Route::get('/{organization}/store', 'Store\IndexController' );
        Route::post('/{organization}/store', 'Store\StoreController' );
        Route::delete('/{organization}/store/{store}', 'Store\DeleteController' );
        Route::get('/{organization}/vendor', 'Vendor\IndexController' );
        Route::post('/{organization}/vendor', 'Vendor\StoreController' );
        Route::delete('/{organization}/vendor/{vendor}', 'Vendor\DeleteController' );
    });
    Route::group(["namespace" => "App\Http\Controllers\API\Integration\Store", "prefix" => "integration/store", "middleware" => []], function(){
        Route::get("/", "IndexController");
        Route::post('/', 'StoreController' );
        Route::get('/{store}', 'ShowController' );
        Route::delete("/{store}", "DeleteController");
        Route::patch("/{store}", "UpdateController");
    });
    Route::group(["namespace" => "App\Http\Controllers\API\Integration\Requisite", "prefix" => "integration/requisite", "middleware" => []], function(){
        Route::get("/", "IndexController");
        Route::post('/', 'StoreController' );
        Route::get('/{requisite}', 'ShowController' );
        Route::delete("/{requisite}", "DeleteController");
        Route::patch("/{requisite}", "UpdateController");
    });
    Route::group(["namespace" => "App\Http\Controllers\API\Integration\BankRequisite", "prefix" => "integration/bank-requisite", "middleware" => []], function(){
        Route::get("/", "IndexController");
        Route::post('/', 'StoreController' );
        Route::get('/{bankrequisite}', 'ShowController' );
        Route::delete("/{bankrequisite}", "DeleteController");
        Route::patch("/{bankrequisite}", "UpdateController");
    });

    Route::group(["namespace" => "App\Http\Controllers\API\ProductCategory", "prefix" => "product/category", "middleware" => []], function() {
        Route::get("/", "IndexController");
        Route::post("/", "StoreController");
        Route::get('/{category}', 'ShowController' );
        Route::delete("/{category}", "DeleteController");
        Route::patch("/{category}", "UpdateController");
    });

    Route::group(["namespace" => "App\Http\Controllers\API\Vendor", "prefix" => "product/vendor", "middleware" => []], function() {
        Route::get("/", "IndexController");
        Route::post("/", "StoreController");
        Route::get('/{vendor}', 'ShowController' );
        Route::delete("/{vendor}", "DeleteController");
        Route::patch("/{vendor}", "UpdateController");
    });
});


