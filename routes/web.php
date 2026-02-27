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
    Route::group(['namespace'=>'Products', 'prefix' => 'products'], function() {
        Route::get("/", IndexController::class)->name("admin.product.index");
        Route::group(['namespace'=>'Categories', 'prefix' => 'categories'], function() {
            Route::get("/", IndexController::class)->name("admin.product.category.index");
            Route::get("/create", CreateController::class)->name("admin.product.category.create");
            Route::post("/", StoreController::class)->name("admin.product.category.store");
            Route::get("/{category}/edit", EditController::class)->name("admin.product.category.edit");
            Route::get("/{category}", ShowController::class)->name("admin.product.category.show");
            Route::patch("/{category}", UpdateController::class)->name("admin.product.category.update");
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
