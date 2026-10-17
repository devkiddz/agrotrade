<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Notification;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminNotificationController extends Controller
{
    protected $notificationService;

    /**
     * Create a new controller instance.
     *
     * @param NotificationService $notificationService
     */
    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    /**
     * Show the admin notifications page
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $notifications = Notification::where('admin_id', Auth::guard('admin')->id())
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.notifications.index', [
            'notifications' => $notifications
        ]);
    }

    /**
     * Show the send message form
     *
     * @return \Illuminate\View\View
     */
    public function showSendMessageForm()
    {
        $users = User::all(['id', 'name', 'email']);

        return view('admin.notifications.send-message', [
            'users' => $users
        ]);
    }

    /**
     * Send message to user
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendMessage(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'type' => 'required|string|in:info,warning,success,danger'
        ]);

        $notification = $this->notificationService->sendAdminMessageToUser(
            $request->user_id,
            $request->title,
            $request->message,
            $request->type
        );

        if ($notification) {
            return redirect()->back()->with('success', 'Message sent successfully!');
        }

        return redirect()->back()->with('error', 'Failed to send message. Please try again.')->withInput();
    }

    /**
     * Mark notification as read
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function markAsRead($id)
    {
        $notification = Notification::find($id);

        if (!$notification || $notification->admin_id !== Auth::guard('admin')->id()) {
            return redirect()->back()->with('error', 'Notification not found or unauthorized.');
        }

        $this->notificationService->markAsRead($id);

        return redirect()->back()->with('success', 'Notification marked as read.');
    }

    /**
     * Mark all notifications as read
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function markAllAsRead()
    {
        $count = $this->notificationService->markAllAsReadForAdmin(Auth::guard('admin')->id());

        return redirect()->back()->with('success', "{$count} notifications marked as read.");
    }

    /**
     * Delete notification
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        $notification = Notification::find($id);

        if (!$notification || $notification->admin_id !== Auth::guard('admin')->id()) {
            return redirect()->back()->with('error', 'Notification not found or unauthorized.');
        }

        $this->notificationService->deleteNotification($id);

        return redirect()->back()->with('success', 'Notification deleted.');
    }

    /**
     * Get unread notifications count
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUnreadCount()
    {
        $count = $this->notificationService->countUnreadForAdmin(Auth::guard('admin')->id());

        return response()->json([
            'unread_count' => $count
        ]);
    }
}
