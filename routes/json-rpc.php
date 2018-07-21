<?php

use App\Http\Controllers\JsonRpcController;
use Illuminate\Support\Facades\Route;

Route::get('rpc', function() {
    $server = app('JsonRpcServer');
    $server->attach(new JsonRpcController());
    $server->execute();
});
