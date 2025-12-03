<?php

namespace App\Providers;

use App\Models\Branch;
use App\Models\GeneralSetting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        if (Schema::hasTable('general_settings')) {
            View::share('generalSetting', GeneralSetting::first());
        }

        View::composer('*', function ($view) {
            if (Schema::hasTable('branches') && Auth::check()) {
                $user = Auth::user();

                // Check if user is Super Admin
                $isSuperAdmin = $user->roles->pluck('name')->contains('Super Admin');

                if ($isSuperAdmin) {
                    $branches = Branch::all();
                } else {
                    // শুধুমাত্র ইউজারের assigned branches নেবে
                    $branches = $user->branches()->with('branch')->get()->pluck('branch');
                }

                View::share('branchInfo', $branches);
            }
            // $view->with('search', $search);
        });
    }
}