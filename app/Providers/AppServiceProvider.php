<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Pagination\Paginator;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Custom service binding example (if needed)
         // $this->app->bind('YourService', function ($app) {
         //      return new YourService();
        // });

         // Example binding an interface to a concrete implementation
         // $this->app->bind(YourInterface::class, YourConcreteClass::class)

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // 1. Extend the Validator:
         Validator::extend('custom_rule', function ($attribute, $value, $parameters, $validator) {
              return strlen($value) > 5; // Example custom rule
        });

          Validator::replacer('custom_rule', function ($message, $attribute, $rule, $parameters) {
             return str_replace(':attribute', $attribute, 'The :attribute must be more than 5 character.');
        });

        // 2. Register custom Blade components
         Blade::component('alert', \App\View\Components\Alert::class);

        // 3. Using a custom paginator
        Paginator::useBootstrapFive();

       // 4. Database query logging
         if (config('app.debug')) {
            DB::listen(function ($query) {
              Log::info(
                 $query->sql,
                  $query->bindings,
                 $query->time
             );
            });
        }
    }
}

