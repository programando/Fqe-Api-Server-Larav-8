<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;
use Symfony\Component\Finder\Finder;

class RouteServiceProvider extends ServiceProvider
{
 
    protected $namespace = 'App\Http\Controllers';
    protected $namespaceApi = 'App\Http\Controllers\Api';

 
    public function boot()
    {

        parent::boot();
    }

 
    public function map()
    {
        $this->mapApiRoutes();
        $this->mapWebRoutes();
        $this->facturasProveedorEventos();
        $this->LoadAdditionalRoutes();

       
    }

 
    protected function mapWebRoutes()
    {
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/web.php'));
    }
 
    protected function mapApiRoutes()
    {
        Route::middleware('api')
             ->namespace($this->namespace)
             ->group(base_path('routes/api.php'));
    }

    protected function facturasProveedorEventos(){
        Route::middleware('api')
           ->namespace($this->namespaceApi)
           ->prefix('proveedores')
           ->group(base_path('routes/factruaProveedorEventos.php'));
        }

        protected function LoadAdditionalRoutes()
        {
            $finder = new Finder();
            $routeFiles = $finder->files()
                ->in(base_path('routes'))
                ->name('*.php')
                ->notName(['web.php', 'console.php', 'channels.php', 'api.php', 'factruaProveedorEventos.php']);
        
            foreach ($routeFiles as $file) {
                require $file->getRealPath();
            }
        }
 
}
