<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

/*
|--------------------------------------------------------------------------
| Autoload Composer Dependencies
|--------------------------------------------------------------------------
|
| Load all Composer packages for the application.
|
*/
require __DIR__ . '/../vendor/autoload.php';

/*
|--------------------------------------------------------------------------
| Bootstrap the Laravel Application
|--------------------------------------------------------------------------
|
| This bootstraps the app from the bootstrap/app.php file.
|
*/
$app = require_once __DIR__ . '/../bootstrap/app.php';

/*
|--------------------------------------------------------------------------
| Handle the Incoming Request
|--------------------------------------------------------------------------
|
| Capture the request, send it through the HTTP kernel, and send back
| the response. Finally, terminate the kernel for any post-response tasks.
|
*/

/** @var Kernel $kernel */
$kernel = $app->make(Kernel::class);

$request = Request::capture();
$response = $kernel->handle($request);

$response->send();

$kernel->terminate($request, $response);
