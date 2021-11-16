<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

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
     * The path to the "home" route for your application.
     *
     * @var string
     */
    public const HOME = '/home';

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
             ->group(function(){
               require base_path('routes/web.php');
               require base_path('routes/web/admin.php');
               require base_path('routes/web/reportes.php');
               require base_path('routes/web/proveedores.php');
               require base_path('routes/web/socios.php');
               require base_path('routes/web/cobros.php');
               require base_path('routes/web/rubros.php');
               require base_path('routes/web/cuentas.php');
               require base_path('routes/web/asientos.php');
               require base_path('routes/web/facturas.php');
               require base_path('routes/web/descuentos.php');
               require base_path('routes/web/retenciones.php');
               require base_path('routes/web/bancos.php');
               require base_path('routes/web/anticipos.php');
               require base_path('routes/web/estado.php');
               require base_path('routes/web/cobrosconfig.php');
               require base_path('routes/web/parametroscontables.php');
             });
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
}
