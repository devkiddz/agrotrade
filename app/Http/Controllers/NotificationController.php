<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
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
     * Get authenticated user's notifications
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserNotifications(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $notifications = $this->notificationService->getUserNotifications(Auth::id(), $perPage);

        return response()->json([
            'notifications' => $notifications,
            'unread_count' => $this->notificationService->countUnreadForUser(Auth::id())
        ]);
    }

    /**
     * Get authenticated admin's notifications
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAdminNotifications(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $adminId = Auth::guard('admin')->id();
        $notifications = $this->notificationService->getAdminNotifications($adminId, $perPage);

        return response()->json([
            'notifications' => $notifications,
            'unread_count' => $this->notificationService->countUnreadForAdmin($adminId)
        ]);
    }

    /**
     * Mark a notification as read
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function markAsRead(Request $request)
    {
        $request->validate([
            'notification_id' => 'required|integer|exists:notifications,id'
        ]);

        $notification = Notification::find($request->notification_id);

        // Check if the notification belongs to the authenticated user or admin
        if (($notification->user_id && $notification->user_id != Auth::id()) &&
            ($notification->admin_id && $notification->admin_id != Auth::guard('admin')->id())) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $success = $this->notificationService->markAsRead($request->notification_id);

        return response()->json([
            'success' => $success,
            'message' => $success ? 'Notification marked as read' : 'Failed to mark notification as read'
        ]);
    }

    /**
     * Mark all notifications as read for the authenticated user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function markAllAsRead()
    {
        if (Auth::guard('admin')->check()) {
            $count = $this->notificationService->markAllAsReadForAdmin(Auth::guard('admin')->id());
        } else {
            $count = $this->notificationService->markAllAsReadForUser(Auth::id());
        }

        return response()->json([
            'success' => true,
            'message' => "{$count} notifications marked as read"
        ]);
    }

    /**
     * Delete a notification
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteNotification(Request $request)
    {
        $request->validate([
            'notification_id' => 'required|integer|exists:notifications,id'
        ]);

        $notification = Notification::find($request->notification_id);

        // Check if the notification belongs to the authenticated user or admin
        if (($notification->user_id && $notification->user_id != Auth::id()) &&
            ($notification->admin_id && $notification->admin_id != Auth::guard('admin')->id())) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $success = $this->notificationService->deleteNotification($request->notification_id);

        return response()->json([
            'success' => $success,
            'message' => $success ? 'Notification deleted successfully' : 'Failed to delete notification'
        ]);
    }

    /**
     * Admin sending a notification to a user
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function sendAdminMessageToUser(Request $request)
    {
        // Ensure this is only accessible by admins
        if (!Auth::guard('admin')->check()) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthorized'], 403);
            }
            return redirect()->route('admin.notifications')->with('error', 'Unauthorized access.');
        }

        $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'type' => 'required|string|in:info,success,warning,danger'
        ]);

        $notification = $this->notificationService->sendAdminMessageToUser(
            $request->user_id,
            $request->title,
            $request->message,
            $request->type
        );

        if ($request->expectsJson()) {
            return response()->json([
                'success' => (bool)$notification,
                'message' => $notification ? 'Message sent successfully' : 'Failed to send message',
                'notification' => $notification
            ]);
        }

        if ($notification) {
            return redirect()->route('admin.notifications')
                ->with('success', 'Notification has been sent to the user successfully.');
        }

        return redirect()->back()
            ->with('error', 'Failed to send notification.')
            ->withInput();
    }

    /**
     * Get count of unread notifications for the authenticated user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUnreadCount()
    {
        if (Auth::guard('admin')->check()) {
            $count = $this->notificationService->countUnreadForAdmin(Auth::guard('admin')->id());
        } else {
            $count = $this->notificationService->countUnreadForUser(Auth::id());
        }

        return response()->json([
            'unread_count' => $count
        ]);
    }

    /**
     * Display user notifications index page
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $perPage = 20;
        $notifications = $this->notificationService->getUserNotifications(Auth::id(), $perPage);
        $title = 'User Notifications';
        return view('user.notifications.index', compact('notifications', 'title'));
    }

    /**
     * Display the specified notification
     *
     * @param int $id
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function show($id)
    {
        $notification = Notification::findOrFail($id);
        $title = 'Notification Details';
        // Check if the notification belongs to the authenticated user
        if ($notification->user_id != Auth::id()) {
            return redirect()->route('notifications')->with('error', 'Unauthorized access to this notification.');
        }

        return view('user.notifications.show', compact('notification', 'title'));
    }

    /**
     * Display admin notifications index page
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function adminIndex()
    {
        $perPage = 20;
        $notifications = Notification::whereNotNull('user_id')
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
            $title = 'Admin Notifications';

        return view('admin.notifications.index', compact('notifications', 'title'));
    }

    /**
     * Display the admin notification detail page
     *
     * @param int $id
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function adminShow($id)
    {
        $notification = Notification::findOrFail($id);
         $title = 'Admin Notification Details';
        // Admin can view any user notification
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('admin.notifications')->with('error', 'Unauthorized access.');
        }

        return view('admin.notifications.show', compact('notification', 'title'));
    }

    /**
     * Display the send notification form for admin
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function showSendMessageForm()
    {
        $users = \App\Models\User::orderBy('name')->get();
        $title = 'Send Notification to User';
        return view('admin.notifications.send-message', compact('users', 'title'));
    }

    /**
     * Web route version of markAsRead for form submissions
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function webMarkAsRead(Request $request)
    {
        $request->validate([
            'notification_id' => 'required|integer|exists:notifications,id'
        ]);

        $notification = Notification::find($request->notification_id);

        // Check if the notification belongs to the authenticated user
        if ($notification->user_id != Auth::id()) {
            return redirect()->back()->with('error', 'Unauthorized');
        }

        $success = $this->notificationService->markAsRead($request->notification_id);

        return redirect()->back()->with(
            $success ? 'success' : 'error',
            $success ? 'Notification marked as read' : 'Failed to mark notification as read'
        );
    }

    /**
     * Web route version of deleteNotification for form submissions
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function webDeleteNotification(Request $request)
    {
        $request->validate([
            'notification_id' => 'required|integer|exists:notifications,id'
        ]);

        $notification = Notification::find($request->notification_id);

        $isAdmin = Auth::guard('admin')->check();

        // Check access permissions
        if (!$isAdmin && $notification->user_id != Auth::id()) {
            return redirect()->back()->with('error', 'Unauthorized');
        }

        $success = $this->notificationService->deleteNotification($request->notification_id);

        $redirectRoute = $isAdmin ? 'admin.notifications' : 'notifications';

        return redirect()->route($redirectRoute)->with(
            $success ? 'success' : 'error',
            $success ? 'Notification deleted successfully' : 'Failed to delete notification'
        );
    }

    /**
     * Create a test notification for admin (only in debug mode)
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createTestNotification(Request $request)
    {
        if (!config('app.debug')) {
            return response()->json(['success' => false, 'message' => 'Test notifications only allowed in debug mode'], 403);
        }

        try {
            $adminId = Auth::guard('admin')->id();
            $title = $request->input('title', 'Test Notification');
            $message = $request->input('message', 'This is a test notification for admin');
            $type = $request->input('type', 'info');

            // Create notification in database
            $notification = new Notification();
            $notification->admin_id = $adminId;
            $notification->title = $title;
            $notification->message = $message;
            $notification->type = $type;
            $notification->is_read = 0;
            $notification->created_at = now();
            $notification->save();

            return response()->json([
                'success' => true,
                'message' => 'Test notification created successfully',
                'notification_id' => $notification->id
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create test notification: ' . $e->getMessage()
            ], 500);
        }
    }
}
