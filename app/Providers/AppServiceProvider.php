<?php

namespace App\Providers;

use App\Models\project;
use App\Models\ProjectView;
use Illuminate\Support\Facades\Auth;
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
    public function boot()
    {
        // Register a view composer for all views
        View::composer('*', function ($view) {
            // Retrieve the currently authenticated user
            $user = Auth::user();

            if ($user) {
                // Check if the user is an admin
                if ($user->admin) {
                    // For admin users
                    $sideprojects = ProjectView::orderBy('viewed_at', 'desc')
                        ->limit(6)
                        ->get();

                    // Pass the projects to all views
                    $view->with('sideprojects', $sideprojects);
                } else {
                    // For regular users
                    $sales = $user->sales;

                    if ($sales) {
                        $sideprojects = Project::where('sales_id', $sales->id)->get();
                    } else {
                        $sideprojects = collect(); // No sales record found
                    }
                    // Pass the user's projects to all views
                    $view->with('sideprojects', $sideprojects);
                }
            }
        });
    }
}
