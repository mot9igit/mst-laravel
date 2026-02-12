<?php

use Illuminate\Support\Facades\Route;

Route::get('/', App\Http\Controllers\IndexController::class)->name('index');

Route::get('/login', App\Http\Controllers\auth\IndexController::class)->name('auth.login');
Route::post('/login', App\Http\Controllers\auth\LoginController::class)->name('auth.login.submit');
Route::get('/logout', App\Http\Controllers\auth\LogoutController::class)->name('auth.logout');

Route::group(['namespace'=>'App\Http\Controllers\admin', 'prefix' => 'adm', "middleware" => "auth"], function() {
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

Route::get('/profile', App\Http\Controllers\front\profile\IndexController::class)->name('front.profile.index');
