<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthorizationController;
use App\Http\Controllers\Admin\DeviceController;

Route::get('hello', function(){
    return 'admin api say: hello';
});

Route::middleware(['throttle:' . config('api.rate_limits.sign')])->group(function () {
    // 登录
    Route::post('login', [AuthorizationController::class, 'login']);
});

Route::group([
    'middleware' => ['auth:admin'],
], function () {
    Route::get('user/info', [AuthorizationController::class, 'getUserInfo']);

    Route::post('device/base', [DeviceController::class, 'getBase']);

    Route::post('device/detail', [DeviceController::class, 'getDetail']);
});
