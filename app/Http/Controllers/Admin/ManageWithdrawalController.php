<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Settings;
use App\Models\Wdmethod;
use App\Models\Withdrawal;
use App\Mail\NewNotification;
use App\Services\NotificationService;
use App\Traits\PingServer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ManageWithdrawalController extends Controller
{
    use PingServer;

    //process withdrawals
    public function pwithdrawal(Request $request)
    {
        $withdrawal=Withdrawal::where('id',$request->id)->first();
        $user=User::where('id',$withdrawal->user)->first();

        // Initialize notification service
        $notificationService = app(NotificationService::class);

        if ($request->action == "Paid") {
            Withdrawal::where('id',$request->id)
            ->update([
                'status' => 'Processed',
            ]);

            $settings=Settings::where('id', '=', '1')->first();

            if ($settings->deduction_option == "AdminApprove") {
            if($withdrawal->user==$user->id){
                User::where('id',$user->id)
                ->update([
                    'account_bal' => $user->account_bal - $withdrawal->to_deduct,
                ]);
            }

            // Create user notification for approved withdrawal
            $notificationService->createUserNotification(
                $user->id,
                'Withdrawal Approved',
                "Your withdrawal request of {$user->currency}{$withdrawal->amount} has been approved and processed. Funds have been sent to your selected account.",
                'success',
                $withdrawal->id,
                'App\\Models\\Withdrawal'
            );

            // Create admin notification about approved withdrawal
            $notificationService->createAdminNotification(
                Auth::guard('admin')->id(),
                'Withdrawal Processed',
                "Withdrawal request of {$user->currency}{$withdrawal->amount} for user {$user->name} has been approved and processed.",
                'success',
                $withdrawal->id,
                'App\\Models\\Withdrawal'
            );

            $message = "This is to inform you that your withdrawal request of $user->currency$withdrawal->amount have approved and funds have been sent to your selected account";

            try {
                Mail::to($user->email)->send(new NewNotification($message, 'Successful Withdrawal', $user->name));
            } catch (\Exception $e) {
                \Log::error('Failed to send withdrawal approval email to user. User: ' . $user->name . ' (' . $user->email . '), Withdrawal ID: ' . $withdrawal->id . ', Amount: ' . $withdrawal->amount . '. Error: ' . $e->getMessage());
            }
        }

        }else {

         $settings = Settings::where('id', '=', '1')->first();
            if($withdrawal->user==$user->id){

                 if ($settings->deduction_option == "userRequest") {
                User::where('id',$user->id)
                ->update([
                    'account_bal' => $user->account_bal +$withdrawal->to_deduct,
                ]);

                 }
                 Withdrawal::where('id',$request->id)
            ->update([
                'status' => 'Rejected',
            ]);

                // Create user notification for rejected withdrawal
                $notificationService->createUserNotification(
                    $user->id,
                    'Withdrawal Rejected',
                    isset($request->reason) ? $request->reason : "Your withdrawal request of {$user->currency}{$withdrawal->amount} has been rejected.",
                    'danger',
                    $withdrawal->id,
                    'App\\Models\\Withdrawal'
                );

                // Create admin notification about rejected withdrawal
                $notificationService->createAdminNotification(
                    Auth::guard('admin')->id(),
                    'Withdrawal Rejected',
                    "Withdrawal request of {$user->currency}{$withdrawal->amount} for user {$user->name} has been rejected.",
                    'warning',
                    $withdrawal->id,
                    'App\\Models\\Withdrawal'
                );

                if ($request->emailsend == "true") {
                    try {
                        Mail::to($user->email)->send(new NewNotification($request->reason,$request->subject, $user->name));
                    } catch (\Exception $e) {
                        \Log::error('Failed to send withdrawal rejection email to user. User: ' . $user->name . ' (' . $user->email . '), Withdrawal ID: ' . $withdrawal->id . ', Amount: ' . $withdrawal->amount . ', Reason: ' . $request->reason . '. Error: ' . $e->getMessage());
                    }
                }

              }

        }

        return redirect()->route('mwithdrawals')->with('success', 'Action Sucessful!');

    }

    public function processwithdraw($id){
         $with = Withdrawal::where('id',$id)->first();
         $method = Wdmethod::where('name', $with->payment_mode)->first();
         $user = User::where('id', $with->user)->first();

         // Create admin notification about viewing withdrawal
         $notificationService = app(NotificationService::class);
         $notificationService->createAdminNotification(
            Auth::guard('admin')->id(),
            'Withdrawal Reviewed',
            "Withdrawal request of {$user->currency}{$with->amount} for user {$user->name} is being reviewed.",
            'info',
            $with->id,
            'App\\Models\\Withdrawal'
         );

        return view('admin.Withdrawals.pwithrdawal',[
            'withdrawal' => $with,
            'method' => $method,
            'user' => $user,
            'title'=>'Process withdrawal Request',
        ]);
    }
}
