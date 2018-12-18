<?php

namespace SmallRuralDog\HelpCenter;

use Illuminate\Support\ServiceProvider;
use SmallRuralDog\HelpCenter\Commands\InstallCommand;
use SmallRuralDog\HelpCenter\Commands\UpdateCommand;

class HelpCenterServiceProvider extends ServiceProvider
{
    protected $commands = [
        InstallCommand::class,
        UpdateCommand::class
    ];

    /**
     * {@inheritdoc}
     */
    public function boot(HelpCenter $extension)
    {
        if (!HelpCenter::boot()) {
            return;
        }

        if ($views = $extension->views()) {
            $this->loadViewsFrom($views, 'help-center');
        }

        if ($this->app->runningInConsole() && $assets = $extension->assets()) {
            $this->publishes([$assets => public_path('vendor/laravel-admin-ext/help-center')], 'help-center');
        }
        if ($this->app->runningInConsole() && $migrations = $extension->migrations()) {
            $this->publishes([$migrations => database_path('migrations')], 'help-center');
        }

        $this->app->booted(function () {
            HelpCenter::routes(__DIR__ . '/../routes/web.php');
        });
    }


    public function register()
    {

        $this->commands($this->commands);
    }
}