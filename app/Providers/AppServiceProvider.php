<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
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
        Gate::define('profile_status', function (User $user) {
            return $user->is_profile_completed == 0;
        });
        Gate::define('employee', function (User $user) {
            return $user->role == 'employee';
        });
        Gate::define('company', function (User $user) {
            return $user->role == 'company';
        });
        Gate::define('admin', function (User $user) {
            return $user->role == 'admin';
        });
       
        Paginator::defaultView('vendor.pagination.bootstrap-5');
    }
}
