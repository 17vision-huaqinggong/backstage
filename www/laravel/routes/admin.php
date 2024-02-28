<?php

use Illuminate\Support\Facades\Route;

Route::get('hello', function(){
    return 'admin api say: hello';
});

Route::middleware(['throttle:' . config('api.rate_limits.sign')])->group(function () {

});

Route::group([
    'middleware' => ['auth:admin'],
], function () {

});
