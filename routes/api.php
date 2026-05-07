<?php

use App\Http\Controllers\API\Files\UploadController;
use App\Http\Controllers\API\RequestApi\User\MeController;
use App\Http\Controllers\API\User\CompleteResetPasswordController;
use App\Http\Controllers\API\User\ResetPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\API\Auth\ApiLoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/enums/{enum}', 'App\Http\Controllers\Enum\IndexController');

Route::post('/login', LoginController::class);

Route::prefix('auth')->group(function () {
    Route::post('/login', ApiLoginController::class);
});



//TODO: Группа внешних запросов
Route::middleware(["auth:sanctum", "logApi"])->group(function ():void {
    Route::get('/user/me', MeController::class);
    Route::post('/user/reset-password', ResetPasswordController::class)
        ->withoutMiddleware(['auth:sanctum']);
    Route::post('/user/reset-password/complete', CompleteResetPasswordController::class)
        ->withoutMiddleware(['auth:sanctum']);
});


Route::middleware(["web", "auth:sanctum"])->group(function (): void {

    Route::post('/upload', UploadController::class)->middleware([]);

    Route::group(["namespace" => "App\Http\Controllers\API\RequestLog", "prefix" => "request-log", "middleware" => []], function () {
        Route::get("/", "IndexController");
    });

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
        Route::get('/document/remain', 'Doc\Remain\IndexController');
        Route::post('/document/remain', 'Doc\Remain\StoreController');
        Route::get('/document/{doc}/remain/{remain}', 'Doc\Remain\ShowController');
        Route::patch("/document/{doc}/remain/{remain}", "Doc\Remain\UpdateController");
        Route::delete('/document/{doc}/remain/{remain}', 'Doc\Remain\DeleteController');

        Route::get("/document", "Doc\IndexController");
        Route::post("/document", "Doc\StoreController");
        Route::get("/{store}/document/{doc}", "Doc\ShowController");
        Route::patch("/{store}/document/{doc}", "Doc\UpdateController");
        Route::delete("/{store}/document/{doc}", "Doc\DeleteController");

        Route::get("/", "IndexController");
        Route::post('/', 'StoreController' );
        Route::get('/{store}', 'ShowController' );
        Route::delete("/{store}", "DeleteController");
        Route::patch("/{store}", "UpdateController");
        Route::get('/{store}/remain', 'Remain\IndexController' );
        Route::post('/{store}/remain', 'Remain\StoreController' );
        Route::get('/{store}/remain/{remain}', 'Remain\ShowController' );
        Route::patch("/{store}/remain/{remain}", "Remain\UpdateController");
        Route::delete('/{store}/remain/{remain}', 'Remain\DeleteController' );

        Route::get('/{store}/remain/{remain}/price', 'Remain\Price\IndexController' );
        Route::post('/{store}/remain/{remain}/price', 'Remain\Price\StoreController' );
        Route::get('/{store}/remain/{remain}/price/{price}', 'Remain\Price\ShowController' );
        Route::patch("/{store}/remain/{remain}/price/{price}", "Remain\Price\UpdateController");
        Route::delete('/{store}/remain/{remain}/price/{price}', 'Remain\Price\DeleteController' );

        Route::get('/{store}/remain/{remain}/history', 'Remain\History\IndexController' );
        Route::post('/{store}/remain/{remain}/history', 'Remain\History\StoreController' );
        Route::get('/{store}/remain/{remain}/history/{history}', 'Remain\History\ShowController' );
        Route::patch("/{store}/remain/{remain}/history/{history}", "Remain\History\UpdateController");
        Route::delete('/{store}/remain/{remain}/history/{history}', 'Remain\History\DeleteController' );

        Route::get('/{store}/catalog', 'RemainCatalog\IndexController' );
        Route::post('/{store}/catalog', 'RemainCatalog\StoreController' );
        Route::get('/{store}/catalog/{catalog}', 'RemainCatalog\ShowController' );
        Route::patch("/{store}/catalog/{catalog}", "RemainCatalog\UpdateController");
        Route::delete('/{store}/catalog/{catalog}', 'RemainCatalog\DeleteController' );


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

    Route::group(["namespace" => "App\Http\Controllers\API\Integration\ContactPerson", "prefix" => "integration/contact-person", "middleware" => []], function() {
        Route::get("/", "IndexController");
        Route::post("/", "StoreController");
        Route::patch("/{contact}", "UpdateController");
        Route::delete("/{contact}", "DeleteController");
    });

    Route::group(["namespace" => "App\Http\Controllers\API\Integration\ApiKey", "prefix" => "integration/api-key", "middleware" => []], function() {
        Route::get("/", "IndexController");
        Route::post("/", "StoreController");
        Route::get('/generate', 'GenerateController');
        Route::patch("/{id}", "UpdateController");
        Route::delete("/{id}", "DeleteController");
    });
});


