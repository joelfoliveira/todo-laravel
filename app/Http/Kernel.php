<?php

namespace todolist\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * @var array
     */
    protected $middleware = [\Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class, \todolist\Http\Middleware\EncryptCookies::class, \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class, \Illuminate\Session\Middleware\StartSession::class, \Illuminate\View\Middleware\ShareErrorsFromSession::class, \todolist\Http\Middleware\VerifyCsrfToken::class,];

    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = ['auth' => \todolist\Http\Middleware\Authenticate::class, 'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class, 'guest' => \todolist\Http\Middleware\RedirectIfAuthenticated::class,];
}
