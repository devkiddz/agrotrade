<?php

namespace App\Http\Livewire\User;

use App\Models\Notification;
use App\Services\NotificationService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Notifications extends Component
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
        return view('livewire.user.notifications', [
            'notifications' => Notification::where('user_id', Auth::id())
                ->orderBy('created_at', 'desc')
                ->paginate(10)
        ]);
    }

    public function markAsRead($id)
    {
        $notification = Notification::find($id);

        if ($notification && $notification->user_id === Auth::id()) {
            $this->notificationService->markAsRead($id);
            $this->emit('notificationMarkedAsRead');
        }
    }

    public function markAllAsRead()
    {
        $this->notificationService->markAllAsReadForUser(Auth::id());
        $this->emit('allNotificationsMarkedAsRead');
    }

    public function deleteNotification($id)
    {
        $notification = Notification::find($id);

        if ($notification && $notification->user_id === Auth::id()) {
            $this->notificationService->deleteNotification($id);
            $this->emit('notificationDeleted');
        }
    }
}
