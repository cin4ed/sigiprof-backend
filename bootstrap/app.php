<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api/v1.php',
        // apiPrefix: 'api/v1',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function () {
            // Api versioning
            $apiVersionPath = base_path('routes/api');
            $apiVersionFiles = glob($apiVersionPath.'/v*.php');

            foreach ($apiVersionFiles as $versionFile) {
                $version = basename($versionFile, '.php');

                Route::middleware('api')
                    ->prefix("api/{$version}")
                    ->group($versionFile);
            }
        },
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->statefulApi();
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
