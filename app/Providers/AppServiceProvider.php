<?php

namespace App\Providers;

use App\Models\GelombangPendaftaran;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

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
        if (Schema::hasTable('gelombang_pendaftarans')) {
            // Share gelombang aktif ke semua view
            View::share('gelombangActive', GelombangPendaftaran::aktif()->first());
        }
    }
}
