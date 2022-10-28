<?php

namespace App\Applications\Post\Providers;

use App\Applications\Post\BLL\CategoryBLL;
use App\Applications\Post\BLL\CategoryBLLInterface;
use App\Applications\Post\BLL\CommentBLL;
use App\Applications\Post\BLL\CommentBLLInterface;
use App\Applications\Post\BLL\PostBLL;
use App\Applications\Post\BLL\PostBLLInterface;
use App\Applications\Post\DAL\CategoryDAL;
use App\Applications\Post\DAL\CategoryDALInterface;
use App\Applications\Post\DAL\CommentDAL;
use App\Applications\Post\DAL\CommentDALInterface;
use App\Applications\Post\DAL\PostDAL;
use App\Applications\Post\DAL\PostDALInterface;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class PostServiceProvider extends ServiceProvider
{
    /**
     * Set the service provider namespace
     *
     */
    protected $namespace = 'App\Applications\Post';
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->routesAreCached()) {
            //  This is already done in the main RouteServiceProvider so not needed here
        } else {

            $this->app->call([$this, 'map']);

            $this->app->booted(function () {
                $this->app['router']->getRoutes()->refreshNameLookups();
                $this->app['router']->getRoutes()->refreshActionLookups();
            });
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(PostDALInterface::class, PostDAL::class);
        $this->app->bind(PostBLLInterface::class, PostBLL::class);
        $this->app->bind(CommentBLLInterface::class, CommentBLL::class);
        $this->app->bind(CommentDALInterface::class, CommentDAL::class);
        $this->app->bind(CategoryBLLInterface::class, CategoryBLL::class);
        $this->app->bind(CategoryDALInterface::class, CategoryDAL::class);
    }

    public function map()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/Post/api.php'));
    }

}
