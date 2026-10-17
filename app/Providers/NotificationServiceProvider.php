<?php

namespace App\Providers;

use App\Services\NotificationService;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Facades\Request;

class NotificationServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(NotificationService::class, function ($app) {
            return new NotificationService();
        });
    }

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        // Listen for user login events
        Event::listen(Login::class, function ($event) {
            if (get_class($event->user) === 'App\Models\User') {
                try {
                    $notificationService = app(NotificationService::class);
                    $agent = new Agent();
                    $device = $agent->device() . ' - ' . $agent->browser();
                    $ipAddress = Request::ip();

                    $notificationService->notifyLogin($event->user, $ipAddress, $device);
                } catch (\Exception $e) {
                    Log::error('Failed to create login notification: ' . $e->getMessage());
                }
            }
        });

        // Listen for user registration events
        Event::listen(Registered::class, function ($event) {
            try {
                $notificationService = app(NotificationService::class);

                // Notify user about successful registration
                $notificationService->createUserNotification(
                    $event->user->id,
                    'Welcome to Algo Trading',
                    'Thank you for registering. Your account has been successfully created.',
                    'registration'
                );

                // Notify admins about new user registration
                $adminTitle = 'New User Registration';
                $adminMessage = "User {$event->user->name} ({$event->user->email}) has registered.";

                $admins = \App\Models\Admin::all();
                foreach ($admins as $admin) {
                    $notificationService->createAdminNotification(
                        $admin->id,
                        $adminTitle,
                        $adminMessage,
                        'registration',
                        $event->user->id,
                        'App\\Models\\User'
                    );
                }
            } catch (\Exception $e) {
                Log::error('Failed to create registration notification: ' . $e->getMessage());
            }
        });
    }
}
