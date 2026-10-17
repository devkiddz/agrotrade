<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Support\Facades\Log;

class NotificationService
{
    /**
     * Create a new notification for a user
     *
     * @param int $userId
     * @param string $title
     * @param string $message
     * @param string $type
     * @param int|null $sourceId
     * @param string|null $sourceType
     * @return Notification|null
     */
    public function createUserNotification($userId, $title, $message, $type = 'info', $sourceId = null, $sourceType = null)
    {
        try {
            // Debug the notification parameters
            Log::info('Creating user notification', [
                'user_id' => $userId,
                'title' => $title,
                'message' => $message,
                'type' => $type,
                'source_id' => $sourceId,
                'source_type' => $sourceType
            ]);

            // Make sure we're using the right model
            $notification = new Notification();
            $notification->user_id = $userId;
            $notification->title = $title;
            $notification->message = $message;
            $notification->type = $type;
            $notification->source_id = $sourceId;
            $notification->source_type = $sourceType;
            $notification->is_read = false;
            $notification->save();

            Log::info('Notification created successfully', ['id' => $notification->id]);
            return $notification;
        } catch (\Exception $e) {
            Log::error('Failed to create user notification: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return null;
        }
    }

    /**
     * Create a new notification for an admin
     *
     * @param int $adminId
     * @param string $title
     * @param string $message
     * @param string $type
     * @param int|null $sourceId
     * @param string|null $sourceType
     * @return Notification|null
     */
    public function createAdminNotification($adminId, $title, $message, $type = 'info', $sourceId = null, $sourceType = null)
    {
        try {
            $notification = Notification::create([
                'admin_id' => $adminId,
                'title' => $title,
                'message' => $message,
                'type' => $type,
                'source_id' => $sourceId,
                'source_type' => $sourceType,
                'is_read' => false
            ]);

            return $notification;
        } catch (\Exception $e) {
            Log::error('Failed to create admin notification: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Create a new notification for a specific event and notify both user and all admins
     *
     * @param int $userId
     * @param string $userTitle
     * @param string $userMessage
     * @param string $adminTitle
     * @param string $adminMessage
     * @param string $type
     * @param int|null $sourceId
     * @param string|null $sourceType
     * @return array
     */
    public function notifyUserAndAdmins($userId, $userTitle, $userMessage, $adminTitle, $adminMessage, $type = 'info', $sourceId = null, $sourceType = null)
    {
        $userNotification = $this->createUserNotification($userId, $userTitle, $userMessage, $type, $sourceId, $sourceType);

        $adminNotifications = [];
        $admins = Admin::all();

        foreach ($admins as $admin) {
            $adminNotifications[] = $this->createAdminNotification(
                $admin->id,
                $adminTitle,
                $adminMessage,
                $type,
                $sourceId,
                $sourceType
            );
        }

        return [
            'user' => $userNotification,
            'admins' => $adminNotifications
        ];
    }

    /**
     * Create notifications for deposit events
     *
     * @param User $user
     * @param float $amount
     * @param string $currency
     * @param int $depositId
     * @return array
     */
    public function notifyDeposit($user, $amount, $currency, $depositId)
    {
        $userTitle = 'Deposit Received';
        $userMessage = "Your deposit of {$currency}{$amount} has been received and is pending approval.";

        $adminTitle = 'New Deposit';
        $adminMessage = "User {$user->name} ({$user->email}) has made a deposit of {$currency}{$amount}.";

        return $this->notifyUserAndAdmins(
            $user->id,
            $userTitle,
            $userMessage,
            $adminTitle,
            $adminMessage,
            'deposit',
            $depositId,
            'App\\Models\\Deposit'
        );
    }

    /**
     * Create notifications for withdrawal events
     *
     * @param User $user
     * @param float $amount
     * @param string $currency
     * @param int $withdrawalId
     * @return array
     */
    public function notifyWithdrawal($user, $amount, $currency, $withdrawalId)
    {
        $userTitle = 'Withdrawal Request';
        $userMessage = "Your withdrawal request for {$currency}{$amount} has been submitted and is pending approval.";

        $adminTitle = 'New Withdrawal Request';
        $adminMessage = "User {$user->name} ({$user->email}) has requested a withdrawal of {$currency}{$amount}.";

        return $this->notifyUserAndAdmins(
            $user->id,
            $userTitle,
            $userMessage,
            $adminTitle,
            $adminMessage,
            'withdrawal',
            $withdrawalId,
            'App\\Models\\Withdrawal'
        );
    }

    /**
     * Create notifications for plan purchase events
     *
     * @param User $user
     * @param string $planName
     * @param float $amount
     * @param string $currency
     * @param int $planId
     * @return array
     */
    public function notifyPlanPurchase($user, $planName, $amount, $currency, $planId)
    {
        $userTitle = 'Investment Plan Activated';
        $userMessage = "Your investment in {$planName} plan for {$currency}{$amount} has been activated.";

        $adminTitle = 'New Investment Plan Purchase';
        $adminMessage = "User {$user->name} ({$user->email}) has purchased the {$planName} plan for {$currency}{$amount}.";

        return $this->notifyUserAndAdmins(
            $user->id,
            $userTitle,
            $userMessage,
            $adminTitle,
            $adminMessage,
            'plan_purchase',
            $planId,
            'App\\Models\\Investment'
        );
    }


    /**
     * Create notifications for trade events
     *
     * @param User $user
     * @param string $planName
     * @param float $amount
     * @param string $currency
     * @param int $planId
     * @return array
     */

    public function notifytradePurchase($user, $assetName, $amount, $currency, $tradeId)
    {
        $userTitle = 'Trade Initiated';
        $userMessage = "Your trade of {$currency}{$amount} in {$assetName} asset has been initiated successfully.";

        $adminTitle = 'New Trade Activity';
        $adminMessage = "User {$user->name} ({$user->email}) has initiated a trade of {$currency}{$amount} in {$assetName} asset.";

        return $this->notifyUserAndAdmins(
            $user->id,
            $userTitle,
            $userMessage,
            $adminTitle,
            $adminMessage,
            'trade',
            $tradeId,
            'App\\Models\\User_plans'
        );
    }

    /**
     * Create notifications for bot purchase events
     *
     * @param User $user
     * @param string $botName
     * @param float $amount
     * @param string $currency
     * @param int $botId
     * @return array
     */
    public function notifyBotPurchase($user, $botName, $amount, $currency, $botId)
    {
        $userTitle = 'Trading Bot Activated';
        $userMessage = "Your investment in {$botName} bot for {$currency}{$amount} has been activated.";

        $adminTitle = 'New Trading Bot Purchase';
        $adminMessage = "User {$user->name} ({$user->email}) has purchased the {$botName} bot for {$currency}{$amount}.";

        return $this->notifyUserAndAdmins(
            $user->id,
            $userTitle,
            $userMessage,
            $adminTitle,
            $adminMessage,
            'bot_purchase',
            $botId,
            'App\\Models\\UserBotInvestment'
        );
    }

    /**
     * Create notifications for profit received events
     *
     * @param User $user
     * @param float $amount
     * @param string $currency
     * @param string $source
     * @param int $sourceId
     * @return array
     */
    public function notifyProfit($user, $amount, $currency, $source, $sourceId, $sourceType)
    {
        $userTitle = 'Profit Received';
        $userMessage = "You have received {$currency}{$amount} profit from your {$source}.";

        $adminTitle = 'Profit Credited';
        $adminMessage = "User {$user->name} ({$user->email}) has received {$currency}{$amount} profit from {$source}.";

        return $this->notifyUserAndAdmins(
            $user->id,
            $userTitle,
            $userMessage,
            $adminTitle,
            $adminMessage,
            'profit',
            $sourceId,
            $sourceType
        );
    }

    /**
     * Create notification for user login events
     *
     * @param User $user
     * @param string $ipAddress
     * @param string $device
     * @return array
     */
    public function notifyLogin($user, $ipAddress, $device)
    {
        $title = 'New Login';
        $message = "New login detected from IP: {$ipAddress} on {$device} at " . now()->format('Y-m-d H:i:s');

        $adminTitle = 'User Login';
        $adminMessage = "User {$user->name} ({$user->email}) logged in from IP: {$ipAddress} on {$device}.";

        return $this->notifyUserAndAdmins(
            $user->id,
            $title,
            $message,
            $adminTitle,
            $adminMessage,
            'login'
        );
    }

    /**
     * Create a notification for direct admin message to user
     *
     * @param int $userId
     * @param string $title
     * @param string $message
     * @param string $type
     * @return Notification
     */
    public function sendAdminMessageToUser($userId, $title, $message, $type = 'info')
    {
        return $this->createUserNotification($userId, $title, $message, $type);
    }

    /**
     * Mark a notification as read
     *
     * @param int $notificationId
     * @return bool
     */
    public function markAsRead($notificationId)
    {
        try {
            $notification = Notification::find($notificationId);
            if (!$notification) {
                return false;
            }

            // Handle different database schemas
            if (isset($notification->is_read)) {
                // Standard notification model
                $notification->is_read = true;
                $notification->save();
                return true;
            } elseif (isset($notification->read_at) || property_exists($notification, 'read_at')) {
                // Laravel's polymorphic notification
                $notification->read_at = now();
                $notification->save();
                return true;
            }

            // If we can't determine the schema, try both
            try {
                $notification->is_read = true;
                $notification->read_at = now();
                $notification->save();
                return true;
            } catch (\Exception $innerE) {
                Log::warning('Failed to update notification with mixed schema: ' . $innerE->getMessage());
                return false;
            }
        } catch (\Exception $e) {
            Log::error('Failed to mark notification as read: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Mark all notifications as read for a user
     *
     * @param int $userId
     * @return int Number of notifications marked as read
     */
    public function markAllAsReadForUser($userId)
    {
        try {
            return Notification::where('user_id', $userId)
                ->where('is_read', false)
                ->update(['is_read' => true]);
        } catch (\Exception $e) {
            Log::error('Failed to mark all notifications as read: ' . $e->getMessage());
            return 0;
        }
    }

    /**
     * Mark all notifications as read for an admin
     *
     * @param int $adminId
     * @return int Number of notifications marked as read
     */
    public function markAllAsReadForAdmin($adminId)
    {
        try {
            $count = 0;

            // First try admin_id column with is_read field
            $count = Notification::where('admin_id', $adminId)
                ->where('is_read', false)
                ->update(['is_read' => true]);

            // If nothing updated, try Laravel's polymorphic notifications
            if ($count === 0) {
                $count = Notification::where('notifiable_id', $adminId)
                    ->where('notifiable_type', 'App\Models\Admin')
                    ->whereNull('read_at')
                    ->update(['read_at' => now()]);
            }

            return $count;
        } catch (\Exception $e) {
            Log::error('Failed to mark all admin notifications as read: ' . $e->getMessage());
            return 0;
        }
    }

    /**
     * Delete a notification
     *
     * @param int $notificationId
     * @return bool
     */
    public function deleteNotification($notificationId)
    {
        try {
            $notification = Notification::find($notificationId);
            if ($notification) {
                $notification->delete();
                return true;
            }
            return false;
        } catch (\Exception $e) {
            Log::error('Failed to delete notification: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Get user notifications with pagination
     *
     * @param int $userId
     * @param int $perPage
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getUserNotifications($userId, $perPage = 10)
    {
        return Notification::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    /**
     * Get admin notifications with pagination
     *
     * @param int $adminId
     * @param int $perPage
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getAdminNotifications($adminId, $perPage = 10)
    {
        return Notification::where('admin_id', $adminId)
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    /**
     * Count unread notifications for a user
     *
     * @param int $userId
     * @return int
     */
    public function countUnreadForUser($userId)
    {
        return Notification::where('user_id', $userId)
            ->where('is_read', false)
            ->count();
    }

    /**
     * Count unread notifications for an admin
     *
     * @param int $adminId
     * @return int
     */
    public function countUnreadForAdmin($adminId)
    {
        try {
            // First try admin_id column with is_read field
            $count = Notification::where('admin_id', $adminId)
                ->where('is_read', false)
                ->count();

            // If no results, try Laravel's polymorphic notifications
            if ($count === 0) {
                $count = Notification::where('notifiable_id', $adminId)
                    ->where('notifiable_type', 'App\Models\Admin')
                    ->whereNull('read_at')
                    ->count();
            }

            return $count;
        } catch (\Exception $e) {
            Log::error('Failed to count unread admin notifications: ' . $e->getMessage());
            return 0;
        }
    }
}
