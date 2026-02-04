<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use App\Models\Setting;

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
        Schema::defaultStringLength(191);

        try {
            $appLogo = Setting::where('key', 'app_logo')->value('value') ?? 'backend/img/logo.svg';
            View::share('appLogo', $appLogo);
        } catch (\Exception $e) {
            // Handle cases where table doesn't exist yet (during migration)
            View::share('appLogo', 'backend/img/logo.svg');
        }
    }
}
