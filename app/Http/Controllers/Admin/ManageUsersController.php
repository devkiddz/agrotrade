<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Signal;
use App\Models\Settings;
use App\Models\Plans;
use App\Models\Agent;
use App\Models\User_plans;
use App\Models\User_signal;
use App\Models\Deposit;
use App\Models\Loan;
use App\Models\Withdrawal;
use App\Models\Tp_Transaction;
use App\Models\Activity;
use App\Models\User_copytradings;
use App\Models\UserBotInvestment;
use App\Models\BotTradingHistory;
use App\Models\Investment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Mail\NewNotification;
use App\Models\Kyc;
use App\Models\Mt4Details;
use App\Traits\PingServer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
class ManageUsersController extends Controller
{
    use PingServer;

    // See user wallet balances
    public function loginactivity($id)
    {

        $user = User::where('id', $id)->first();

        return view('admin.Users.loginactivity', [
            'activities' => Activity::where('user', $id)->orderByDesc('id')->get(),
            'title' => "$user->name login activities",
            'user' => $user,
        ]);
    }

    public function showUsers($id)
    {
        $user = User::where('id', $id)->first();
        $ref = User::whereNull('ref_by')->where('id', '!=', $id)->get();


        return view('admin.Users.referral', [
            'title' => "Add users to $user->name referral list",
            'user' => $user,
            'ref' => $ref,

        ]);
    }

    public function fetchUsers()
    {
        $users = User::orderByDesc('id')->get();
        return response()->json([
            'message' => 'Success',
            'data' => $users,
            'code' => 200
        ]);
    }


    public function addReferral(Request $request)
    {
        $user = User::where('id', $request->user_id)->first();
        $ref = User::where('id', $request->ref_id)->first();

        $ref->ref_by = $user->id;
        $ref->save();
        return redirect()->back()
            ->with('success', "$ref->name is now referred by $user->name successfully");
    }

    public function clearactivity($id)
    {
        $activities = Activity::where('user', $id)->get();

        if (count($activities) > 0) {
            foreach ($activities as $act) {
                Activity::where('id', $act->id)->delete();
            }
            return redirect()->back()
                ->with('success', 'Activity Cleared Successfully!');
        }
        return redirect()->back()
            ->with('message', 'No Activity to clear!');
    }

    public function markplanas($status, $id)
    {
        User_plans::where('id', $id)->update([
            'active' => $status,
        ]);
        return redirect()->back()
            ->with('success', "Plan Active state changed to $status");
    }
    public function markloanas($status, $id)
    {
        Loan::where('id', $id)->update([
            'active' => $status,
        ]);
        return redirect()->back()
            ->with('success', "Loan state changed to $status");
    }


    public function signalmarkas($status, $id)
    {
        User_signal::where('id', $id)->update([
            'status' => $status,
        ]);
        return redirect()->back()
            ->with('success', "Signal Status state changed to $status");
    }

    public function viewuser($id)
    {
        $user = User::where('id', $id)->first();
        $plans = Plans::where('type','main')->get();
        $signals = Signal::where('type','main')->get();
        include 'currencies.php';
        return view('admin.Users.userdetails', [
            'user' => $user,
            'currencies' => $currencies,
            'pl' => Plans::orderByDesc('id')->get(),
            'title' => "Manage $user->name",
            'plans' =>$plans,
            'signals'=>$signals,
        ]);
    }
    //ban/disable user
    public function ublock($id)
    {
        $user = User::find($id);

        if (!$user) {
            return redirect()->back()->with('error', 'User not found!');
        }

        $user->update([
            'status' => 'banned', // Using 'banned' instead of 'blocked' for clarity
        ]);

        // Log out the user from all sessions if they're currently logged in
        \DB::table('sessions')->where('user_id', $id)->delete();

        // You can also invalidate remember tokens if needed
        $user->remember_token = null;
        $user->save();

        return redirect()->back()->with('success', 'User account has been banned/disabled successfully! The user will be redirected to a blocked page if they try to login.');
    }

    //unban/enable user
    public function unblock($id)
    {
        $user = User::find($id);

        if (!$user) {
            return redirect()->back()->with('error', 'User not found!');
        }

        $user->update([
            'status' => 'active',
        ]);

        return redirect()->back()->with('success', 'User account has been unbanned/enabled successfully! The user can now login normally.');
    }

    //Turn on/off user trade
    public function usertrademode($id, $action)
    {
        if ($action == "on") {
            $action = "Profit";
        } elseif ($action == "off") {
            $action = "Loss";
        } else {
            return redirect() - back()->with('message', "Unknown action!");
        }

        User::where('id', $id)->update([
            'tradetype' => $action,
        ]);
        return redirect()->back()->with('success', "Action sucessful.");
    }

    //Manually Verify users email
    public function emailverify($id)
    {
        User::where('id', $id)->update([
            'email_verified_at' => \Carbon\Carbon::now(),
        ]);
        return redirect()->back()->with('success', 'User Email have been verified');
    }

    //Reset Password
    public function resetpswd($id)
    {
        User::where('id', $id)
            ->update([
                'password' => Hash::make('user01236'),
            ]);
        return redirect()->back()->with('success', 'Password has been reset to default');
    }

    //Clear user Account
    public function clearacct(Request $request, $id)
    {
        $settings = Settings::where('id', 1)->first();

        $deposits = Deposit::where('user', $id)->get();
        if (!empty($deposits)) {
            foreach ($deposits as $deposit) {
                Deposit::where('id', $deposit->id)->delete();
            }
        }

        $withdrawals = Withdrawal::where('user', $id)->get();
        if (!empty($withdrawals)) {
            foreach ($withdrawals as $withdrawals) {
                Withdrawal::where('id', $withdrawals->id)->delete();
            }
        }

        User::where('id', $id)->update([
            'account_bal' => '0',
            'roi' => '0',
            'bonus' => '0',
            'ref_bonus' => '0',
        ]);
        return redirect()->back()->with('success', "Account cleared to $settings->currency 0.00");
    }

    //Access users account
    public function switchuser($id)
    {
        $user = User::where('id', $id)->first();
        Auth::loginUsingId($user->id, true);
        return redirect()->route('dashboard')->with('success', "You are logged in as $user->name !");
    }

    //Manually Add Trading History to Users Route
    public function addHistory(Request $request)
    {
        $user = User::where('id', $request->user_id)->first();
        $user_bal = $user->account_bal;
        $user_roi = $user->roi;
        $amount = $request->amount;
        $leverage = $request->leverage;
        $asset = $request->plan;
        $expire = $request->expire;
        $type = $request->type;
        $trade_type = $request->tradetype;
        $expiration =  explode(" ",$request['expire']);
        $digit = $expiration[0];
        $frame = $expiration[1];
        $toexpire =  "add". $frame;
        $end_at = Carbon::now()->$toexpire($digit)->toDateTimeString();

        // Initialize notification service
        $notificationService = app(\App\Services\NotificationService::class);

        //save trade into user_plans table
        $userplanid = DB::table('user_plans')->insertGetId([
            'plan' => 1,
            'user' => $user->id,
            'amount' => $amount,
            'active' => 'expired',
            'assets' => $asset,
            'leverage' =>$leverage,
            'inv_duration'=>$request['expire'],
            'type'=> $trade_type,
            'expire_date' => $end_at,
            'activated_at' => \Carbon\Carbon::now(),
            'last_growth' => \Carbon\Carbon::now(),
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        //create Buy/Sell history
        Tp_Transaction::create([
            'user' => $user->id,
            'plan' => $asset,
            'amount'=>$amount,
            'type'=>$trade_type,
            'leverage'=>$leverage,
        ]);

        if($request->type=='WIN'){
            $profit = $leverage * $amount*0.01;


                        User::where('id', $user->id)
                    ->update([
                        'roi' =>  $user_roi + $profit,
                    ]);

                    // Create notification for profitable trade
                    $notificationService->createUserNotification(
                        $user->id,
                        'Trade Profit',
                        "You earned a profit of {$profit} from a {$asset} trade with {$leverage}x leverage.",
                        'success',
                        $userplanid,
                        'App\\Models\\User_plans'
                    );

                    //create history
                    Tp_Transaction::create([
                        'user' => $user->id,
                        'plan' => $asset,
                        'amount'=>$profit,
                        'type'=>'WIN',
                        'leverage'=> $leverage,
                    ]);



        }else{
                         $loss = (100-$leverage)*$amount*0.01;


                         $amountloss = ($leverage)*$amount*0.01;
                            User::where('id', $user->id)
                            ->update([
                                'account_bal' =>$user_bal - $amountloss,
                            ]);

                            // Create notification for loss trade
                            $notificationService->createUserNotification(
                                $user->id,
                                'Trade Loss',
                                "Your {$asset} trade with {$leverage}x leverage resulted in a loss of {$amountloss}.",
                                'danger',
                                $userplanid,
                                'App\\Models\\User_plans'
                            );

                            Tp_Transaction::create([
                                'user' => $user->id,
                                'plan' => $asset,
                                'amount'=>$amountloss,
                                'type'=>'LOSE',
                                'leverage'=> $leverage,
                            ]);

        }

        // Notify admins about the manual trade addition
        $adminTitle = 'Manual Trade Added';
        $adminMessage = "Admin " . Auth::guard('admin')->user()->name . " added a " .
                        ($type == 'WIN' ? 'profit' : 'loss') . " trade of {$amount} {$asset} with {$leverage}x leverage for user {$user->name}.";

        $notificationService->createAdminNotification(
            Auth::guard('admin')->id(),
            $adminTitle,
            $adminMessage,
            $type == 'WIN' ? 'success' : 'warning',
            $userplanid,
            'App\\Models\\User_plans'
        );

        return redirect()->back()
            ->with('success', 'Trade Executed Sucessful!');
    }


//Manually Add Plan History to Users Route
public function addplanhistory(Request $request)
{
    Tp_Transaction::create([
        'user' => $request->user_id,
        'plan' => $request->plan,
        'amount' => $request->amount,
        'type' => $request->type,
    ]);
    $user = User::where('id', $request->user_id)->first();
    $user_bal = $user->account_bal;

    // if (isset($request['amount']) > 0) {
    //     User::where('id', $request->user_id)
    //         ->update([
    //             'account_bal' => $user_bal + $request->amount,
    //         ]);
    // }
    $user_roi = $user->roi;
    if (isset($request['type']) == "ROI") {
        User::where('id', $request->user_id)
            ->update([
                'roi' => $user_roi + $request->amount,
            ]);
    }

    return redirect()->back()
        ->with('success', 'Action Sucessful!');
}




//Manually Add Signal History to Users Route
public function addsignalhistory(Request $request)
{

    $user = User::where('id', $request->user_id)->first();
    $signal = Signal::where('name', $user->signals)->first();

    $signalid = $signal->id;
    $amount = $request->amount;
    $leverage = $request->leverage;
    $asset = $request->asset;
    $expire = $request->expire;
    $order_type = $request->order_type;

     //save trade into user_plans table
      DB::table('user_signals')->insertGetId([
        'signals' =>  $signalid,
        'user' => $user->id,
        'amount' => $amount,
        'asset' => $asset,
        'expiration' => $expire,
        'status'=>'ongoing',
        'leverage' =>$leverage,
        'order_type'=> $order_type,
        'created_at' => \Carbon\Carbon::now(),
        'updated_at' => \Carbon\Carbon::now(),
    ]);



    // if (isset($request['amount']) > 0) {
    //     User::where('id', $request->user_id)
    //         ->update([
    //             'account_bal' => $user_bal + $request->amount,
    //         ]);
    // }

    return redirect()->back()
        ->with('success', 'Signal Created Sucessful!');
}


public function deleteloan($id)
    {
        Loan::where('id', $id)->delete();
        return redirect()->back()->with('success', 'User Loan deleted successfully!');
    }
    //Delete user
    public function delsystemuser($id)
    {
        //delete the user's withdrawals and deposits
        $deposits = Deposit::where('user', $id)->get();
        if (!empty($deposits)) {
            foreach ($deposits as $deposit) {
                Deposit::where('id', $deposit->id)->delete();
            }
        }
        $withdrawals = Withdrawal::where('user', $id)->get();
        if (!empty($withdrawals)) {
            foreach ($withdrawals as $withdrawals) {
                Withdrawal::where('id', $withdrawals->id)->delete();
            }
        }
        //delete the user plans
        $userp = User_plans::where('user', $id)->get();
        if (!empty($userp)) {
            foreach ($userp as $p) {
                //delete plans that their owner does not exist
                User_plans::where('id', $p->id)->delete();
            }
        }

        //delete the user loans
        $userp = Loan::where('user', $id)->get();
        if (!empty($userp)) {
            foreach ($userp as $p) {
                //delete plans that their owner does not exist
                Loan::where('id', $p->id)->delete();
            }
        }

        $usersingal = User_signal::where('user', $id)->get();
        if (!empty($usersingal)) {
            foreach ( $usersingal as $p) {
                //delete plans that their owner does not exist
                User_signal::where('id', $p->id)->delete();
            }
        }

        // delete user copy trading records
        $usercopytradings = User_copytradings::where('user', $id)->get();
        if (!empty($usercopytradings)) {
            foreach ($usercopytradings as $copytrading) {
                User_copytradings::where('id', $copytrading->id)->delete();
            }
        }

        // delete user bot investments and related trading history
        $userbotinvestments = UserBotInvestment::where('user_id', $id)->get();
        if (!empty($userbotinvestments)) {
            foreach ($userbotinvestments as $botinvestment) {
                // First delete all trading history for this bot investment
                BotTradingHistory::where('user_bot_investment_id', $botinvestment->id)->delete();
                // Then delete the bot investment
                UserBotInvestment::where('id', $botinvestment->id)->delete();
            }
        }

        // delete user investments
        $userinvestments = Investment::where('user', $id)->get();
        if (!empty($userinvestments)) {
            foreach ($userinvestments as $investment) {
                Investment::where('id', $investment->id)->delete();
            }
        }

        // delete user transaction history
        $usertransactions = Tp_Transaction::where('user', $id)->get();
        if (!empty($usertransactions)) {
            foreach ($usertransactions as $transaction) {
                Tp_Transaction::where('id', $transaction->id)->delete();
            }
        }


        //delete the user from agent model if exists
        $agent = Agent::where('agent', $id)->first();
        if (!empty($agent)) {
            Agent::where('id', $agent->id)->delete();
        }

        if (DB::table('mt4_details')->where('client_id', $id)->exists()) {
            Mt4Details::where('client_id', $id)->delete();
        }

        // delete user from verification list
        if (DB::table('kycs')->where('user_id', $id)->exists()) {
            Kyc::where('user_id', $id)->delete();
        }

        User::where('id', $id)->delete();
        return redirect()->route('manageusers')
            ->with('success', 'User Account deleted successfully!');
    }

    //update users info
    public function edituser(Request $request)
    {

        User::where('id', $request['user_id'])
            ->update([
                'name' => $request['name'],
                'email' => $request['email'],
                'country' => $request['country'],
                'username' => $request['username'],
                'phone' => $request['phone'],
                'ref_link' => $request['ref_link'],
                'currency'=>$request['currency'],
                's_currency'=>$request['s_currency'],
            ]);
        return redirect()->back()->with('success', 'User details updated Successfully!');
    }

    //numberoftrades

    public function  numberoftrades(Request $request)
    {

        User::where('id', $request['user_id'])
            ->update([
                'numberoftrades' => $request['numberoftrades'],



            ]);
        return redirect()->back()->with('success', 'User number of trades before withdrawal updated Successfully!');
    }
//user tax


public function withdrawalcode(Request $request)
    {

        User::where('id', $request['user_id'])
            ->update([

                'withdrawal_code' => $request['withdrawal_code'],
                 'user_withdrawalcode' => $request['user_withdrawalcode'],


            ]);
        return redirect()->back()->with('success', 'User Withrawal Code  details updated Successfully!');
    }

 public function usertax(Request $request)
    {

        User::where('id', $request['user_id'])
            ->update([
                'taxtype' => $request['taxtype'],
                'taxamount' => $request['taxamount'],


            ]);
        return redirect()->back()->with('success', 'User Tax details updated Successfully!');
    }


    public function notifyuser(Request $request)
    {
        // Initialize notification service
        $notificationService = app(\App\Services\NotificationService::class);
        $user = User::where('id', $request['user_id'])->first();

        User::where('id', $request['user_id'])
            ->update([
                'notify' => $request['notify'],
                'notify_status' => $request['notifystatus'],
            ]);

        // Create user notification about plan upgrade status
        $notificationService->createUserNotification(
            $request['user_id'],
            'Notification',
            "{$request['notify']}",
            'info'
        );

        // Create admin notification
        $notificationService->createAdminNotification(
            Auth::guard('admin')->id(),
            'User Plan Upgrade Updated',
            "Admin " . Auth::guard('admin')->user()->name . " updated  notification for user {$user->name}.",
            'info',
            $request['user_id'],
            'App\\Models\\User'
        );

        return redirect()->back()->with('success', 'User notification Successfully!');
    }



    public function upgradesignalstatus(Request $request)
    {
        // Initialize notification service
        $notificationService = app(\App\Services\NotificationService::class);
        $user = User::where('id', $request['user_id'])->first();

        User::where('id', $request['user_id'])
            ->update([
                'signal_status' => $request['signal_status'],
                'user_signal' => $request['user_signal'],
            ]);

        // Create user notification about signal upgrade
        $notificationService->createUserNotification(
            $request['user_id'],
            'Signal Status',
            "{$request['signal_status']}",
            'info'
        );

        // Create admin notification
        $notificationService->createAdminNotification(
            Auth::guard('admin')->id(),
            'User Signal Status Updated',
            "Admin " . Auth::guard('admin')->user()->name . " updated signal status for user {$user->name} to {$request['signal_status']}.",
            'info',
            $request['user_id'],
            'App\\Models\\User'
        );

        return redirect()->back()->with('success', 'User Upgrade Signal updated Successfully!');
    }


    public function upgradeplanstatus(Request $request)
    {
        // Initialize notification service
        $notificationService = app(\App\Services\NotificationService::class);
        $user = User::where('id', $request['user_id'])->first();

        User::where('id', $request['user_id'])
            ->update([
                'plan_status' => $request['planstatus'],
                'user_plan_upgade' => $request['user_plan'],
            ]);

        // Create user notification about plan status upgrade
        $notificationService->createUserNotification(
            $request['user_id'],
            'Plan Status ',
            "{$request['planstatus']}",
            'info'
        );

        // Create admin notification
        $notificationService->createAdminNotification(
            Auth::guard('admin')->id(),
            'User Plan Status Updated',
            "Admin " . Auth::guard('admin')->user()->name . " updated plan status for user {$user->name} to {$request['planstatus']}.",
            'info',
            $request['user_id'],
            'App\\Models\\User'
        );

        return redirect()->back()->with('success', 'User notification updated Successfully!');
    }
    //Send mail to one user
    public function sendmailtooneuser(Request $request)
    {
        $mailduser = User::where('id', $request->user_id)->first();

        // Initialize notification service
        $notificationService = app(\App\Services\NotificationService::class);

        // Send email
        Mail::to($mailduser->email)->send(new NewNotification($request->message, $request->subject, $mailduser->name));

        // Create user notification about the message
        $notificationService->createUserNotification(
            $request->user_id,
            '{{$request->subject}}',
            "You have received a new message: {$request->message}",
            'message'
        );

        // Create admin notification for tracking
        $notificationService->createAdminNotification(
            Auth::guard('admin')->id(),
            'Message Sent to User',
            "Admin " . Auth::guard('admin')->user()->name . " sent a message '{$request->subject}' to user {$mailduser->name}.",
            'message',
            $request->user_id,
            'App\\Models\\User'
        );

        return redirect()->back()->with('success', 'Your message was sent successfully!');
    }

    // Send Mail to all users
    public function sendmailtoall(Request $request)
    {

        if ($request->category == "All") {
            User::select(['email', 'id'])->chunkById(100, function ($users) use ($request) {
                foreach ($users as $user) {
                    Mail::to($user->email)->send(new NewNotification($request->message, $request->subject, $request->title, null, null, $request->greet));
                }
            });
        } elseif ($request->category == "No active plans") {
            User::whereDoesntHave('plans', function (Builder $query) {
                $query->where('active', '!=', 'yes');
            })->select(['email', 'id'])->chunkById(100, function ($users) use ($request) {
                foreach ($users as $user) {
                    Mail::to($user->email)->send(new NewNotification($request->message, $request->subject, $request->title, null, null, $request->greet));
                }
            });
        } elseif ($request->category == "No deposit") {
            User::doesntHave('dp')->select(['email', 'id'])->chunkById(100, function ($users) use ($request) {
                foreach ($users as $user) {
                    Mail::to($user->email)->send(new NewNotification($request->message, $request->subject, $request->title, null, null, $request->greet));
                }
            });
        } elseif ($request->category == "Select Users") {
            DB::table('users')
                ->whereIn('id', array_column($request->users, null))
                ->select(['email', 'id'])
                ->chunkById(100, function ($users) use ($request) {
                    foreach ($users as $user) {
                        Mail::to($user->email)->send(new NewNotification($request->message, $request->subject, $request->title, null, null, $request->greet));
                    }
                });
        }

        return redirect()->back()->with('success', 'Your message was sent successfully!');
    }

    // mark user trade as profit
    public function markprofit($id)
    {

        $trade = User_plans::where('id', $id)->first();

        $user = User::find($trade->user);
        $account_bal = $user->account_bal;
        $roi   = $user->roi;
        $profit = $trade->leverage*$trade->amount*0.01;
        User::where('id', $user->id)
        ->update([
            'roi' => $roi + $profit,
            'account_bal' => $account_bal + $trade->amount,
        ]);
        //create history
        Tp_Transaction::create([
            'user' => $user->id,
            'plan' => $trade->assets,
            'amount'=>$profit,
            'type'=>'WIN',
            'leverage'=>$trade->leverage,
        ]);


        return redirect()->back()->with('success', 'Trade has been marked as profit successfully!');
    }

    // Mark user trade as loss
    public function markloss($id)
    {
        $trade = User_plans::where('id', $id)->first();
        $user = User::find($trade->user);
        $account_bal = $user->account_bal;
        $roi   = $user->roi;
        $loss = (100-$trade->leverage)*$trade->amount*0.01;
        $amountloss = ($trade->leverage)*$trade->amount*0.01;
        User::where('id', $user)
         ->update([
             'account_bal' => $account_bal + $loss,
         ]);
        //create history
        Tp_Transaction::create([
            'user' => $user->id,
            'plan' => $trade->assets,
            'amount'=>$amountloss,
            'type'=>'LOSE',
            'leverage'=>$trade->leverage,
        ]);

        return redirect()->back()->with('success', 'Trade has been marked as loss successfully!');
    }

    public function deleteplan($id)
    {
        User_plans::where('id', $id)->delete();
        return redirect()->back()->with('success', 'User Plan deleted successfully!');
    }


    public function deletesignal($id)
    {
        User_signal::where('id', $id)->delete();
        return redirect()->back()->with('success', 'User signal deleted successfully!');
    }

    public function saveuser(Request $request)
    {

        $request->validate([
            'name' => 'required|max:255',
            'username' => 'required|unique:users,username',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:8|confirmed',
        ]);

        $thisid = DB::table('users')->insertGetId([
            'name' => $request['name'],
            'email' => $request['email'],
            'ref_by' => NULL,
            'username' => $request['username'],
            'password' => Hash::make($request->password),
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        //assign referal link to user
        $settings = Settings::where('id', '=', '1')->first();
        $user = User::where('id', $thisid)->first();

        User::where('id', $thisid)
            ->update([
                'ref_link' => $settings->site_address . '/ref/' . $user->username,
            ]);
        return redirect()->back()->with('success', 'User created Sucessfully!');
    }
}
