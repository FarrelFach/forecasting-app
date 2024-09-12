<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

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
         // Define a gate for the 'admin' role
         Gate::define('penjualan', function (User $user) {
            return $user->role === 'penjualan';
        });

        // Define a gate for the 'manager' role
        Gate::define('gudang', function (User $user) {
            return $user->role === 'gudang';
        });
    }
}
