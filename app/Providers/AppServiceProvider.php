<?php

namespace App\Providers;

use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
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
        View::composer('*', function ($view) {
            $user = Auth::user(); // Get the logged-in user
    
            if ($user && $user->id == 1) {
                // Admin (ID = 1) sees all notifications
                $notifications = Notification::with('users')->where('user_id', $user->id ?? 0)->get()->sortByDesc('created_at');
            } else {
                // Regular users see only their notifications
                $notifications = Notification::with('users')->where('user_id', $user->id ?? 0)->get()->sortByDesc('created_at');
            }
    
            $view->with('notifications', $notifications);
        });
    }
}
