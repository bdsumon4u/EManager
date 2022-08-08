<?php

namespace App\Providers;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;
use Inertia\Response;
use Inertia\ResponseFactory;

class InertiaThemeProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->extend(ResponseFactory::class, fn () => new InertiaFactory());
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides(): array
    {
        return [InertiaFactory::class];
    }
}

class InertiaFactory extends ResponseFactory
{
    /**
     * @param  string  $component
     * @param  array|Arrayable  $props
     * @return Response
     */
    public function render(string $component, $props = []): Response
    {
        $theme = (function_exists('tenant') ? tenant('theme') : '') ?: 'default';
        $pagePath = system_path('themes/'.$theme.'/resources/js/Pages/');
        file_exists($pagePath.$component.'.vue') && ($namespace = 'themes/'.$theme.'::');

        return parent::render(($namespace ?? '').$component, $props);
    }
}
