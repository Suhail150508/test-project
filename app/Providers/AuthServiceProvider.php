<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();


        // Protecting the laravel websockets Debug Dashboard
        Gate::define('viewWebSocketsDashboard', function ($user = null) {
            if ($user === null) {
                // User is not authenticated, show a custom error message
            }

            // return in_array($user->email, [
            //     //
            // ]);
        });
    }
}
