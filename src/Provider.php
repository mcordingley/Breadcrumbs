<?php

namespace MCordingley\Breadcrumbs;

use Exception;
use Illuminate\Contracts\Container\Container;
use Illuminate\Support\ServiceProvider;
use MCordingley\Breadcrumbs\Formatters\View;
use MCordingley\Breadcrumbs\Loaders\JsonLoader;

final class Provider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'breadcrumbs');
    }

    public function register()
    {
        $this->publishes([
            __DIR__ . '/../config/breadcrumbs.php' => config_path('breadcrumbs.php'),
            __DIR__ . '/../resources/breadcrumbs.json' => resources_path('breadcrumbs.json'),
        ]);

        $this->app->singleton('breadcrumbs', Factory::class);

        $this->app->singleton(Loader::class, function (Container $app) {
            return $this->buildLoader($app);
        });

        $this->app->singleton(Formatter::class, function (Container $app) {
            return $this->buildFormatter($app);
        });
    }

    private function buildLoader(Container $app): Loader
    {
        switch (config('breadcrumbs.loader')) {
            case 'custom':
                return $this->buildCustomLoader($app);
            case 'json':
                return new JsonLoader(config('breadcrumbs.loaders.json.path'));
            default:
                throw new Exception('Invalid loader.');
        }
    }

    private function buildCustomLoader(Container $app): Loader
    {
        $factory = $app->make(config('breadcrumbs.loaders.custom.via'));

        return $factory();
    }

    private function buildFormatter(Container $app): Formatter
    {
        switch (config('breadcrumbs.formatter')) {
            case 'custom':
                return $this->buildCustomFormatter($app);
            case 'view':
                return new View(config('breadcrumbs.formatters.view.path'));
            default:
                throw new Exception('Invalid formatter.');
        }
    }

    private function buildCustomFormatter(Container $app): Formatter
    {
        $factory = $app->make(config('breadcrumbs.formatters.custom.via'));

        return $factory();
    }
}
