<?php

use Yiisoft\Router\Route;
use App\Endpoint\Status\Action as SampleAction;

return [
    Route::get('/status')->action([SampleAction::class, 'run'])
];
