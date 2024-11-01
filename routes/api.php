<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProdukController;
use App\Http\Controllers\Api\ReportController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::controller(AuthController::class)->group(function () {
    Route::post('/auth/signin', 'signinAction');
    Route::post('/auth/register', 'registerAction');
});

Route::middleware(['jwt.auth'])->group(function () {
    Route::middleware(['role.admin'])->group(function () {
        Route::controller(UserController::class)->group(function () {
            Route::get('/users/list', 'list');
            Route::get('/users/detail/{user}', 'detail');
            Route::post('/users/add', 'addAction');
            Route::put('/users/update/{user}', 'updateAction');
            Route::delete('/users/remove/{user}', 'deleteAction');
        });

        Route::controller(ProdukController::class)->group(function () {
            Route::get('/produk/list', 'list');
            Route::get('/produk/detail/{produk}', 'detail');
            Route::post('/produk/add', 'addAction');
            Route::put('/produk/update/{produk}', 'updateAction');
            Route::delete('/produk/remove/{produk}', 'deleteAction');
        });

        Route::controller(ReportController::class)->group(function () {
            Route::get('/report/list', 'list');
        });
    });
    Route::middleware(['role.kasir'])->group(function () {
        Route::controller(OrderController::class)->group(function () {
            Route::get('/order/list', 'list');
            Route::get('/order/detail/{transaksi}', 'detail');
            Route::post('/order/add', 'addAction');
            Route::delete('/order/remove/{transaksi}', 'deleteAction');
        });
    });
});
