<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Peminjaman;
use App\Observers\PeminjamanObserver;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Peminjaman::observe(PeminjamanObserver::class);
    }
}
