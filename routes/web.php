<?php

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use App\Mail\TestMail;

Route::get('/', App\Http\Controllers\IndexController::class)->name('index');

Route::get('/upload', function () {
    $file = public_path('images/banner.png');
    $url = Storage::disk('tws3')->putFileAs("test", $file, 'banner.png');
    dd($url);

    return 'Файл загружен!';
});

Route::get('/login', App\Http\Controllers\Auth\IndexController::class)->name('login');
Route::post('/login', App\Http\Controllers\Auth\LoginController::class)->name('auth.login.submit');
Route::post('/logout', App\Http\Controllers\Auth\LogoutController::class)->name('auth.logout');

Route::group(['namespace'=>'App\Http\Controllers\Admin', 'prefix' => 'adm', "middleware" => "auth"], function() {
    Route::get('/', IndexController::class)->name('admin.index');
    Route::group(['namespace'=>'Profile', 'prefix' => 'profile'], function() {
        Route::get("/", IndexController::class)->name("admin.profile.index");
    });
    Route::group(['namespace'=>'System', 'prefix' => 'system'], function() {
        Route::group(['namespace'=>'Geo', 'prefix' => 'geo'], function() {
            Route::get("/", IndexController::class)->name("admin.system.geo");
        });
    });
    Route::group(['namespace'=>'User', 'prefix' => 'users'], function() {
        Route::get("/", IndexController::class)->name("admin.user.index");
        Route::get("/create", CreateController::class)->name("admin.user.create");
        Route::get("/{user}", UpdateController::class)->name("admin.user.update");
    });

    Route::group(['prefix' => 'organization'], function() {
        Route::get("/", App\Http\Controllers\Admin\Integration\Organization\IndexController::class)->name("admin.integration.organization.index");
        Route::get("/create", App\Http\Controllers\Admin\Integration\Organization\CreateController::class)->name("admin.integration.organization.create");

        Route::prefix('/{organization}')->group(function () {
            Route::get("/", App\Http\Controllers\Admin\Integration\Organization\UpdateController::class)->name("admin.integration.organization.update");
            Route::group(['prefix' => '/requisite'], function () {
                Route::get("/create", App\Http\Controllers\Admin\Integration\Requisite\CreateController::class)->name("admin.integration.organization.requisite.create");
                Route::prefix('/{requisite}')->group(function () {
                    Route::get("/", App\Http\Controllers\Admin\Integration\Requisite\UpdateController::class)->name("admin.integration.organization.requisite.update");
                    Route::group(['prefix' => '/bank-requisite'], function () {
                        Route::get("/create", App\Http\Controllers\Admin\Integration\BankRequisite\CreateController::class)->name("admin.integration.organization.bank-requisite.create");
                        Route::get("/{bankrequisite}", App\Http\Controllers\Admin\Integration\BankRequisite\UpdateController::class)->name("admin.integration.organization.bank-requisite.update");
                    });
                });
            });
        });
    });

    Route::group(['prefix' => 'store'], function() {
        Route::get("/", App\Http\Controllers\Admin\Integration\Store\IndexController::class)->name("admin.integration.store.index");
        Route::get("/create", App\Http\Controllers\Admin\Integration\Store\CreateController::class)->name("admin.integration.store.create");

    });

    Route::group(['namespace'=>'Products', 'prefix' => 'product'], function() {
        Route::get("/", IndexController::class)->name("admin.product.index");
        Route::group(['namespace'=>'Categories', 'prefix' => 'category'], function() {
            Route::get("/", IndexController::class)->name("admin.product.category.index");
            Route::get("/create", CreateController::class)->name("admin.product.category.create");
            Route::get("/{category}", UpdateController::class)->name("admin.product.category.update");
        });
    });
});


Route::get('/test-email', function () {
    Mail::to('artpetropavlovskij@gmail.com')->send(
        new TestMail([
            'name' => 'Тестовый пользователь'
        ])
    );

    return 'Тестовое письмо отправлено! Проверьте почту.';
});

Route::get('/profile', App\Http\Controllers\Front\Profile\IndexController::class)->name('front.profile.index');
