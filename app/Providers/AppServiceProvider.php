<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /*К форме добавляем скрытое поле с пустым значением (null)
        Если оно заполнено, значит форма отправлена спамом.
        */
        Validator::extend('isnull', function ($attribute, $value, $parameters, $validator) {
            return $value === null;
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
