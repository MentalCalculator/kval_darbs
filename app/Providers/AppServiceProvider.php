<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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
        Validator::extend('strong_password', function ($attribute, $value, $parameters, $validator) {
            // Implement your custom password strength rules
            return preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/',
                $value);
        });

        Validator::replacer('strong_password', function ($message, $attribute, $rule, $parameters) {
            return str_replace(':attribute', $attribute, ':attribute should include at least one lowercase letter, one uppercase letter, one number, and one special character.');
        });
    }
}
