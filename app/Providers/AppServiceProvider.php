<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema; // <--- TAMBAH BARIS INI
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Schema::defaultStringLength(191); // <--- TAMBAH BARIS INI
        if (config('app.env') !== 'local') {
        \URL::forceScheme('https');
         }
    }

    public function register()
    {
        //
    }
}
