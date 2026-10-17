<?php

namespace App\Http\Livewire\Admin;

use App\Models\Notification;
use App\Services\NotificationService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AdminNotificationsCount extends Component
{
    public $notificationsCount = 0;
    protected $listeners = [
        'notificationMarkedAsRead' => '$refresh',
        'allNotificationsMarkedAsRead' => '$refresh',
        'notificationDeleted' => '$refresh',
        'refreshNotificationCount' => '$refresh'
    ];

    protected $notificationService;

    public function boot(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function render()
    {
        $this->notificationsCount = $this->notificationService->countUnreadForAdmin(Auth::guard('admin')->id());
        return view('livewire.admin.notifications-count');
    }
}
