<?php

Route::group(['prefix' => 'task', 'as' => 'task.', 'namespace' => 'Modules\Task\Http\Controllers'], function () {
    Route::apiResource('tasks', 'TaskController');
});
