<?php

namespace App\Util\Providers;

use App\Util\DataExport\DataExportService;
use App\Util\DataExport\DataExportServiceInterface;
use App\Util\Helper\HelperService;
use App\Util\Helper\HelperServiceInterface;
use Illuminate\Support\ServiceProvider;

class UtilServiceProvider extends ServiceProvider
{
    /**
     * Set the service provider namespace
     *
     */
    protected $namespace = 'App\Util';
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(HelperServiceInterface::class, HelperService::class);
        $this->app->bind(DataExportServiceInterface::class, DataExportService::class);
    }


}
