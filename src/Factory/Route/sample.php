<?php

use Yiisoft\Router\Route;
use App\Endpoint\Sample\Action as SampleAction;

return [
    Route::get('/sample', [SampleAction::class, 'run'])
];
