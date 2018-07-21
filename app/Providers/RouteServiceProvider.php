<?php

namespace App\Providers;

use Illuminate\Routing\Router;
use Upgate\LaravelJsonRpc\Contract\ServerInterface as JsonRpcServerContract;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        //
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
             ->middleware('api')
             ->namespace($this->namespace)
             ->group(base_path('routes/api.php'));
    }

    /**
     * @param Router $router
     */
    protected function mapJsonRPC(Router $router)
    {
        $router->group(['namespace' => $this->namespace],
            function (Router $router) {
                // Create an instance of JsonRpcServer
                $jsonRpcServer = $this->app->make(JsonRpcServerContract::class);
                // Set default controller namespace
                $jsonRpcServer->setControllerNamespace($this->namespace);
                // Register middleware aliases configured for Laravel router
                $jsonRpcServer->registerMiddlewareAliases($router->getMiddleware());

                require app_path('routes/json-rpc.php');
            }
        );
    }
}
