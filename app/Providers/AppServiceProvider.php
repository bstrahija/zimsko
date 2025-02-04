<?php

namespace App\Providers;

use App\Models\Event;
use App\Models\User;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        view()->composer('*', function ($view) {
            $currentEvent = Event::current() ?: (Event::last() ?: null);
            $view->with('currentEvent', $currentEvent);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Model::shouldBeStrict();
        Model::unguard();

        Url::forceScheme('https');

        Gate::define('viewPulse', function (User $user) {
            return $user && $user->hasRole(['superadmin', 'admin']);
        });

        Vite::usePrefetchStrategy('aggressive');
    }
}
