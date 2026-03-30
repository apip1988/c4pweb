<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema; // <--- TAMBAH BARIS INI

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Schema::defaultStringLength(191); // <--- TAMBAH BARIS INI
    }

    public function register()
    {
        //
    }
}