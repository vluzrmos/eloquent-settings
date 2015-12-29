<?php

namespace Vluzrmos\EloquentSettings\Providers;

use Illuminate\Support\ServiceProvider;
use Vluzrmos\EloquentSettings\Setting;

class EloquentSettingsServiceProvider extends ServiceProvider
{

    /**
     *
     */
    public function boot()
    {
        $baseDir = __DIR__.'/../..';

        $this->publishes([
            $baseDir.'/config/settings.php' => config_path('settings.php'),
            $baseDir.'/migrations' => database_path('migrations')
        ]);
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->app->singleton(Setting::class, Setting::class);
        $this->app->alias(Setting::class, 'setting');
        $this->app->alias(Setting::class, 'settings');
    }
}