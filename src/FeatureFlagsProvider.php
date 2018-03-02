<?php

namespace AlfredNutileInc\LaravelFeatureFlags;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Support\Facades\Log;

/**
 * Class FeatureFlagsProvider
 * @package AlfredNutileInc\LaravelFeatureFlags
 * @codeCoverageIgnore
 * Most of this is default Laravel provider setup
 */
class FeatureFlagsProvider extends ServiceProvider
{

    use FeatureFlagHelper;

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->publishesConfiguration();

        $this->registerRoutes();

        $this->registerViewFiles();

        $this->injectLinks();

        $this->registerFeatureFlags();

        $this->publishMigrations();

        $this->publishViews();

        $this->registerPolicies();

        $this->defineFeatureFlagGate($gate);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerViewFiles();
    }

    private function registerRoutes()
    {
        if (method_exists($this->app, 'routesAreCached')) {
            if (!$this->app->routesAreCached()) {
                require __DIR__ . '/routes.php';
            }
        }
    }

    private function registerViewFiles()
    {
        $this->loadViewsFrom(__DIR__ . '/../views', 'laravel-feature-flag');
    }

    private function injectLinks()
    {
        if (config('laravel-feature-flag.add_link_to_menu', false)) {
            view()->composer(
                config('laravel-feature-flag.default_view', 'layouts.default'),
                function ($view) {
                    if ($view->offsetExists('links')) {
                        $links_original = $view->offsetGet('links');
                        $links = [
                            [
                                'title' => 'Feature Flags',
                                'url' => route('laravel-feature-flag.index'),
                                'icon' => 'flag-o'
                            ]
                        ];

                        $view->with('links', array_merge($links_original, $links));
                    }
                }
            );
        }
    }

    private function publishMigrations()
    {
        $this->publishes([
            __DIR__ . '/../database/migrations/' => database_path('migrations')
        ], 'migrations');
    }

    private function publishViews()
    {
        $this->publishes([
            __DIR__ . '/../views/' => base_path('resources/views/vendor/laravel-feature-flag')
        ], 'views');
    }

    private function defineFeatureFlagGate($gate)
    {
        $gate->define('feature-flag', function ($user, $flag_id) {
            try {
                return \Feature\Feature::isEnabled($flag_id);
            } catch (\Exception $e) {
                if (config("laravel-feature-flag.logging")) {
                    Log::info(
                        sprintf(
                            "FeatureFlagsProvider: error with feature flag %s. '%s'",
                            $flag_id,
                            $e->getMessage()
                        )
                    );
                }
                // Defaults to false in case of error.
                return false;
            }
        });
    }

    private function publishesConfiguration()
    {
        $this->publishes([
            __DIR__ . '/../config/laravel-feature-flag.php' => config_path('laravel-feature-flag.php'),
        ], 'config');
    }
}
