<?php

Route::group(['namespace' => 'Modules\Core\Http\Controllers', 'middleware' => ['auth:api']], function () {
    Route::get('addresses/{postcode}', 'AddressController@show')->where('postcode', '[0-9]{8}');
});
