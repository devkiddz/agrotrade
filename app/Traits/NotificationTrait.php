<?php

namespace App\Traits;

use App\Services\NotificationService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

trait NotificationTrait
{
    /**
     * Send a deposit notification
     *
     * @param float $amount
     * @param string $currency
     * @param int $depositId
     * @return void
     */
    protected function sendDepositNotification($amount, $currency, $depositId)
    {
        try {
            $notificationService = app(NotificationService::class);
            $user = Auth::user();

            $notificationService->notifyDeposit($user, $amount, $currency, $depositId);
        } catch (\Exception $e) {
            Log::error('Failed to send deposit notification: ' . $e->getMessage());
        }
    }

    /**
     * Send a withdrawal notification
     *
     * @param float $amount
     * @param string $currency
     * @param int $withdrawalId
     * @return void
     */
    protected function sendWithdrawalNotification($amount, $currency, $withdrawalId)
    {
        try {
            $notificationService = app(NotificationService::class);
            $user = Auth::user();

            $notificationService->notifyWithdrawal($user, $amount, $currency, $withdrawalId);
        } catch (\Exception $e) {
            Log::error('Failed to send withdrawal notification: ' . $e->getMessage());
        }
    }

    /**
     * Send a plan purchase notification
     *
     * @param string $planName
     * @param float $amount
     * @param string $currency
     * @param int $planId
     * @return void
     */
    protected function sendPlanPurchaseNotification($planName, $amount, $currency, $planId)
    {
        try {
            $notificationService = app(NotificationService::class);
            $user = Auth::user();

            $notificationService->notifyPlanPurchase($user, $planName, $amount, $currency, $planId);
        } catch (\Exception $e) {
            Log::error('Failed to send plan purchase notification: ' . $e->getMessage());
        }
    }



/**
     * Send a plan purchase notification
     *
     * @param string $planName
     * @param float $amount
     * @param string $currency
     * @param int $planId
     * @return void
     */
    protected function sendtradeNotification($planName, $amount, $currency, $planId)
    {
        try {
            $notificationService = app(NotificationService::class);
            $user = Auth::user();

            $notificationService->notifytradePurchase($user, $planName, $amount, $currency, $planId);
        } catch (\Exception $e) {
            Log::error('Failed to send trade purchase notification: ' . $e->getMessage());
        }
    }


    /**
     * Send a bot purchase notification
     *
     * @param string $botName
     * @param float $amount
     * @param string $currency
     * @param int $botId
     * @return void
     */
    protected function sendBotPurchaseNotification($botName, $amount, $currency, $botId)
    {
        try {
            $notificationService = app(NotificationService::class);
            $user = Auth::user();

            $notificationService->notifyBotPurchase($user, $botName, $amount, $currency, $botId);
        } catch (\Exception $e) {
            Log::error('Failed to send bot purchase notification: ' . $e->getMessage());
        }
    }

    /**
     * Send a profit notification
     *
     * @param float $amount
     * @param string $currency
     * @param string $source
     * @param int $sourceId
     * @param string $sourceType
     * @return void
     */
    protected function sendProfitNotification($amount, $currency, $source, $sourceId, $sourceType)
    {
        try {
            $notificationService = app(NotificationService::class);
            $user = Auth::user();

            $notificationService->notifyProfit($user, $amount, $currency, $source, $sourceId, $sourceType);
        } catch (\Exception $e) {
            Log::error('Failed to send profit notification: ' . $e->getMessage());
        }
    }

    /**
     * Send a direct notification to user
     *
     * @param int $userId
     * @param string $title
     * @param string $message
     * @param string $type
     * @param int|null $sourceId
     * @param string|null $sourceType
     * @return void
     */
    protected function sendDirectUserNotification($userId, $title, $message, $type = 'info', $sourceId = null, $sourceType = null)
    {
        try {
            $notificationService = app(NotificationService::class);

            $notificationService->createUserNotification($userId, $title, $message, $type, $sourceId, $sourceType);
        } catch (\Exception $e) {
            Log::error('Failed to send direct user notification: ' . $e->getMessage());
        }
    }

    /**
     * Send a direct notification to admin
     *
     * @param int $adminId
     * @param string $title
     * @param string $message
     * @param string $type
     * @param int|null $sourceId
     * @param string|null $sourceType
     * @return void
     */
    protected function sendDirectAdminNotification($adminId, $title, $message, $type = 'info', $sourceId = null, $sourceType = null)
    {
        try {
            $notificationService = app(NotificationService::class);

            $notificationService->createAdminNotification($adminId, $title, $message, $type, $sourceId, $sourceType);
        } catch (\Exception $e) {
            Log::error('Failed to send direct admin notification: ' . $e->getMessage());
        }
    }
}
