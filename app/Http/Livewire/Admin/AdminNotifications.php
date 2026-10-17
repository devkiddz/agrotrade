<?php

namespace App\Http\Livewire\Admin;

use App\Models\Notification;
use App\Services\NotificationService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class AdminNotifications extends Component
{
    use WithPagination;

    protected $listeners = ['refreshNotifications' => '$refresh'];
    protected $notificationService;

    public function boot(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function render()
    {
        return view('livewire.admin.notifications', [
            'notifications' => Notification::where('admin_id', Auth::guard('admin')->id())
                ->orderBy('created_at', 'desc')
                ->paginate(10)
        ]);
    }

    public function markAsRead($id)
    {
        $notification = Notification::find($id);

        if ($notification && $notification->admin_id === Auth::guard('admin')->id()) {
            $this->notificationService->markAsRead($id);
            $this->emit('notificationMarkedAsRead');
        }
    }

    public function markAllAsRead()
    {
        $this->notificationService->markAllAsReadForAdmin(Auth::guard('admin')->id());
        $this->emit('allNotificationsMarkedAsRead');
    }

    public function deleteNotification($id)
    {
        $notification = Notification::find($id);

        if ($notification && $notification->admin_id === Auth::guard('admin')->id()) {
            $this->notificationService->deleteNotification($id);
            $this->emit('notificationDeleted');
        }
    }
}
