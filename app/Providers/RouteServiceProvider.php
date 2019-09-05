<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Route;


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
    public function boot(): void
    {
        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map(): void
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes(): void
    {
        $this->mapWebBaseRoutes();
        $this->mapWebUsersRoutes();
        $this->mapWebProductsRoutes();
        $this->mapWebTeamsRoutes();
        $this->mapWebPermissionsRoutes();
        $this->mapWebAdminRoutes();
    }
    
    protected function mapWebBaseRoutes(): void
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web/base.php'));
    }
    
    protected function mapWebUsersRoutes(): void
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web/users.php'));
    }
    
    protected function mapWebProductsRoutes(): void
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web/products.php'));
    }
    
    protected function mapWebTeamsRoutes(): void
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web/teams.php'));
    }
    
    protected function mapWebPermissionsRoutes(): void
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web/permissions.php'));
    }
    
    protected function mapWebAdminRoutes(): void
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->prefix('admin')
            ->group(base_path('routes/web/admin.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes(): void
    {
        $this->mapApiAuthRoutes();
        $this->mapApiProductsRoutes();
        $this->mapApiUserRoutes();
        $this->mapApiHoursRoutes();
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
    
    /**
     * Maps api hours routes.
     *
     * @return void
     */
    protected function mapApiHoursRoutes(): void
    {
        Route::prefix('api/v1/hours')
            ->middleware(['api', 'auth:api'])
            ->namespace($this->namespace)
            ->group(base_path('routes/api/v1/hours.php'));
    }
}
