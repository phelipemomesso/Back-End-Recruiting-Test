<?php

Route::group(['prefix' => 'user', 'as' => 'user.', 'namespace' => 'Modules\User\Http\Controllers', 'middleware' => ['auth:api', 'verified']], function () {
    Route::apiResource('users', 'UserController', ['only' => ['index', 'show']]);
});
