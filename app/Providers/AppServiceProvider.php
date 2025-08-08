<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\LazyLoadingViolationException;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //Avoid Lazy Loading of Models
        Model::preventLazyLoading(
            fn ($query) => throw new LazyLoadingViolationException(
                'Lazy loading is not allowed. Use eager loading instead.'
            )
        );
    }
}
