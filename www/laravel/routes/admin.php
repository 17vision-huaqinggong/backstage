<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthorizationController;

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
});
