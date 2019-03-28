<?php

namespace App\Providers;

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
        $this->mapWebBaseRoutes();
        $this->mapWebUsersRoutes();
        $this->mapWebProductsRoutes();
        $this->mapWebTeamsRoutes();
        $this->mapWebPermissionsRoutes();
    }
    
    protected function mapWebBaseRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web/base.php'));
    }
    
    protected function mapWebUsersRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web/users.php'));
    }
    
    protected function mapWebProductsRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web/products.php'));
    }
    
    protected function mapWebTeamsRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web/teams.php'));
    }
    
    protected function mapWebPermissionsRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web/permissions.php'));
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
        $this->mapApiAuthRoutes();
        $this->mapApiProductsRoutes();
        $this->mapApiUserRoutes();
    }
    
    /**
     * Maps api authentication routes.
     *
     * @return void
     */
    protected function mapApiAuthRoutes(): void
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/api/auth.php'));
    }
    
    /**
     * Maps api product routes.
     *
     * @return void
     */
    protected function mapApiProductsRoutes(): void
    {
        Route::prefix('api/v1/products')
            ->middleware(['api', 'auth:api'])
            ->namespace($this->namespace)
            ->group(base_path('routes/api/v1/products.php'));
    }
    
    /**
     * Maps api user routes.
     *
     * @return void
     */
    protected function mapApiUserRoutes(): void
    {
        Route::prefix('api/v1/user')
            ->middleware(['api', 'auth:api'])
            ->namespace($this->namespace)
            ->group(base_path('routes/api/v1/user.php'));
    }
}
