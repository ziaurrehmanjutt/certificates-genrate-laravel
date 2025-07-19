<?php

namespace App\Providers;

use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;
use BezhanSalleh\FilamentLanguageSwitch\LanguageSwitch;

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
        Vite::prefetch(concurrency: 3);

        LanguageSwitch::configureUsing(
            fn($switch) =>
            $switch->locales(['en', 'ar'])
                ->flags([
                    'en' => asset('lang/us.svg'),
                    'ar' => asset('lang/ar.svg'),
                ])
                ->flagsOnly()
        );
    }
}
