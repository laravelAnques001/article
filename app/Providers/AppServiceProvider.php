<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(250);
        Validator::extend('gst', function ($attribute, $value, $parameters, $validator) {
            // Define the regular expression pattern for a valid GST number
            $pattern = '/^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}[Z]{1}[0-9A-Z]{1}$/';

            // Check if the value matches the pattern
            return preg_match($pattern, $value) === 1;
        });

        Validator::replacer('gst', function ($message, $attribute, $rule, $parameters) {
            return "The $attribute is not a valid GST number.";
        });
    }
}
