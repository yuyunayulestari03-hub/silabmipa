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
            $settings = Setting::whereIn('key', ['app_logo', 'app_name'])->pluck('value', 'key');
            
            $appLogo = $settings['app_logo'] ?? 'backend/img/logo_lab.jpg';
            $appName = $settings['app_name'] ?? 'SILAB MIPA';
            
            View::share('appLogo', $appLogo);
            View::share('appName', $appName);
        } catch (\Exception $e) {
            // Handle cases where table doesn't exist yet (during migration)
            View::share('appLogo', 'backend/img/logo.svg');
            View::share('appName', 'SILAB MIPA');
        }
    }
}
