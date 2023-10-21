<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

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
        // Human Resources (SUPER)
        Gate::define('hr', function(User $user) {
        return $user->role === 3;
        });

        // Atasan
        Gate::define('atasan', function(User $user) {
        return $user->role === 1 || $user->role === 2 || $user->role === 3;
        });

        // Branch Manager
        Gate::define('cabang', function(User $user) {
        return $user->role === 2 || $user->role === 3;
        });
        
        // Manager
        Gate::define('manager', function(User $user) {
        return $user->role === 1 || $user->role === 3;
        });
        
        // Karyawan Biasa 
        Gate::define('karyawan', function(User $user) {
        return $user->role === 0 || $user->role === 3;
        });
    }
}
