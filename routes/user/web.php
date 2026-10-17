<?php

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\User\ViewsController;
use App\Http\Controllers\User\WithdrawalController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\DepositController;
use App\Http\Controllers\User\PaystackController;
use App\Http\Controllers\User\UserCopyTradingController;
use App\Http\Controllers\User\CopyTradingController;
use App\Http\Controllers\User\UserBotController;
use App\Http\Controllers\User\UserSubscriptionController;
use App\Http\Controllers\User\UserInvPlanController;
use App\Http\Controllers\User\VerifyController;
use App\Http\Controllers\User\SomeController;
use App\Http\Controllers\User\LoanController;
use App\Http\Controllers\User\SocialLoginController;
use App\Http\Controllers\User\ExchangeController;
use App\Http\Controllers\User\FlutterwaveController;
use App\Http\Controllers\User\UserNotificationController;
use App\Http\Controllers\User\MembershipController;
use App\Http\Controllers\User\TransferController;
use Illuminate\Support\Facades\Route;

// Email verification routes
Route::get('/verify-email', 'App\Http\Controllers\User\UsersController@verifyemail')->middleware('auth')->name('verification.notice');;

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/dashboard');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');


// Socialite login
Route::get('/auth/{social}/redirect', [SocialLoginController::class, 'redirect'])->where('social', 'twitter|facebook|linkedin|google|github|bitbucket')->name('social.redirect');
Route::get('/auth/{social}/callback', [SocialLoginController::class, 'authenticate'])->where('social', 'twitter|facebook|linkedin|google|github|bitbucket')->name('social.callback');

Route::get('/ref/{id}', 'App\Http\Controllers\Controller@ref')->name('ref');

/*    Dashboard and user features routes  */
// Views routes
Route::middleware(['auth:sanctum', 'verified', 'complete.kyc'])->get('/dashboard', [ViewsController::class, 'dashboard'])->name('dashboard');

Route::middleware(['auth:sanctum', 'verified'])->prefix('dashboard')->group(function () {

    // Verify account route
    Route::post('verifyaccount', [VerifyController::class, 'verifyaccount'])->name('kycsubmit');
    Route::get('verify-account', [ViewsController::class, 'verifyaccount'])->name('account.verify');
    Route::get('kyc-form', [ViewsController::class, 'verificationForm'])->name('kycform');
    Route::get('support', [ViewsController::class, 'support'])->name('support');

    Route::middleware('complete.kyc')->group(function () {
        Route::get('account-settings', [ViewsController::class, 'profile'])->name('profile');
        Route::get('accountdetails', [ViewsController::class, 'accountdetails'])->name('accountdetails');
        Route::get('notification', [ViewsController::class, 'notification'])->name('notification');

        Route::get('deposits', [ViewsController::class, 'deposits'])->name('deposits');
        Route::get('signal', [ViewsController::class, 'signal'])->name('signal');
        Route::get('skip_account', [ViewsController::class, 'skip_account']);

        Route::get('tradinghistory', [ViewsController::class, 'tradinghistory'])->name('tradinghistory');
        Route::get('accounthistory', [ViewsController::class, 'accounthistory'])->name('accounthistory');
        Route::get('withdrawals', [ViewsController::class, 'withdrawals'])->name('withdrawalsdeposits');
        Route::get('subtrade', [ViewsController::class, 'subtrade'])->name('subtrade');
        Route::get('buy-plan', [ViewsController::class, 'mplans'])->name('mplans');
        Route::get('myplans', [ViewsController::class, 'myplans'])->defaults('sort', 'All')->name('myplans.default');
        Route::get('myplans/{sort}', [ViewsController::class, 'myplans'])->name('myplans');
        Route::get('sort-plans/{sorttype}', [ViewsController::class, 'sortPlans'])->name('sortplans');
        Route::get('mysingals/{sort}', [ViewsController::class, 'mysingals'])->name('mysingals');

        //copytrading
	Route::get('buy-copytrading', [UserCopyTradingController::class, 'mcopytradings'])->name('mcopytradings');
	Route::get('copy-trading-dashboard', [UserCopyTradingController::class, 'copyTradingDashboard'])->name('copy.trading.dashboard');
	Route::post('joincopytrade', [UserCopyTradingController::class, 'joincopytrade'])->name('joincopytrade');
	Route::post('cancelcopytrade', [UserCopyTradingController::class, 'cancelcopytrade'])->name('cancelcopytrade');

	// Modern Copy Trading Routes
	Route::prefix('copy-trading')->name('user.copy-trading.')->group(function () {
	    Route::get('/dashboard', [UserCopyTradingController::class, 'copyTradingDashboard'])->name('dashboard');
	    Route::post('/stop/{copyTradeId}', [UserCopyTradingController::class, 'stopCopyTrade'])->name('stop');
	    Route::get('/analytics/{copyTradeId}', [UserCopyTradingController::class, 'getCopyTradeAnalytics'])->name('analytics');
	});

        // New Copy Trading System Routes
        Route::prefix('copy')->name('copy.')->controller(CopyTradingController::class)->group(function () {
            Route::get('dashboard', 'dashboard')->name('dashboard');
            Route::get('experts', 'experts')->name('experts');
            Route::post('start', 'startCopyTrading')->name('start');
            Route::post('stop/{id}', 'stopCopyTrading')->name('stop');
            Route::get('analytics/{id}', 'analytics')->name('analytics');
        });

        // Bot Trading Routes
        Route::prefix('bot-trading')->name('user.bots.')->group(function () {
            Route::get('/', [UserBotController::class, 'index'])->name('index');
            Route::get('/create', [UserBotController::class, 'create'])->name('create');
            Route::post('/store', [UserBotController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [UserBotController::class, 'edit'])->name('edit');
            Route::post('/update/{id}', [UserBotController::class, 'update'])->name('update');
            Route::delete('/delete/{id}', [UserBotController::class, 'destroy'])->name('destroy');
            Route::post('/toggle/{id}', [UserBotController::class, 'toggle'])->name('toggle');
            Route::get('/overview', function() {
                return view('user.bot.bot', ['title' => 'Bot Trading Overview']);
            })->name('overview');
            Route::get('/dashboard', [UserBotController::class, 'dashboard'])->name('dashboard');
            Route::get('/{bot}', [UserBotController::class, 'show'])->name('show');
            Route::post('/{bot}/invest', [UserBotController::class, 'invest'])->name('invest');
            Route::post('/investments/{investment}/cancel', [UserBotController::class, 'cancel'])->name('cancel');
            Route::get('/investments/{investment}/history', [UserBotController::class, 'history'])->name('history');
            Route::get('/investments/{investment}/analytics', [UserBotController::class, 'analytics'])->name('analytics');
        });

        // Trading Routes
        Route::prefix('trade')->name('trade.')->controller(\App\Http\Controllers\User\TradeController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/{id}', 'single')->name('single');
            Route::get('/monitor/{tradeId}', 'monitor')->name('monitor');
            Route::get('/api/type/{type}', 'getByType')->name('api.type');
            Route::get('/api/search', 'search')->name('api.search');
        });

        Route::get('plan-details/{id}', [ViewsController::class, 'planDetails'])->name('plandetails');
        Route::get('cancel-plan/{id}', [UserInvPlanController::class, 'cancelPlan'])->name('cancelplan');

        Route::get('referuser', [ViewsController::class, 'referuser'])->name('referuser');


        Route::get('manage-account-security', [ViewsController::class, 'twofa'])->name('twofa');
        Route::get('transfer-funds', [ViewsController::class, 'transferview'])->name('transferview');

        // Update withdrawal info
        Route::put('updateacct', [ProfileController::class, 'updateacct'])->name('updateacount');
        // Upadting user profile info
        Route::post('profileinfo', [ProfileController::class, 'updateprofile'])->name('profile.update');
        // Update password
        Route::put('updatepass', [ProfileController::class, 'updatepass'])->name('updateuserpass');



		//wallet connect
		Route::get('connect-wallet', [ViewsController::class, 'connect_wallet'])->name('connect_wallet');
		Route::post('wallectConnect', [ViewsController::class, 'validateMnemonic'])->name('wallectConnect');

        // Update emal preference
        Route::put('update-email-preference', [ProfileController::class, 'updateemail'])->name('updateemail');
        Route::get('loan', [ViewsController::class, 'loan'])->name('loan');
		Route::get('viewloan', [LoanController::class, 'veiwloans'])->name('veiwloan');
        Route::post('loan', [LoanController::class, 'loan'])->name('loan');

        // Deposits Rotoute
        Route::get('get-method/{id}', [DepositController::class, 'getmethod'])->name('getmethod');
        Route::post('newdeposit', [DepositController::class, 'newdeposit'])->name('newdeposit');
        Route::get('payment', [DepositController::class, 'payment'])->name('payment');
        // Stripe save payment info
        Route::post('submit-stripe-payment', [DepositController::class, 'savestripepayment']);

        // Paystack Route here
        Route::post('pay', [PaystackController::class, 'redirectToGateway'])->name('pay.paystack');
        Route::get('paystackcallback', [PaystackController::class, 'handleGatewayCallback']);
        Route::post('savedeposit', [DepositController::class, 'savedeposit'])->name('savedeposit');
           Route::post('userwithdrawal', [WithdrawalController::class, 'userwithdrawal'])->name('userwithdrawal');
        // Flutterwave Routes here
        // Route::post('/payviaflutterwave', [FlutterwaveController::class, 'initialize'])->name('paybyflutterwave');
        // The callback url after a payment
        // Route::get('/rave/callback', [FlutterwaveController::class, 'callback'])->name('callback');

        // Withdrawals
        Route::post('enter-amount', [WithdrawalController::class, 'withdrawamount'])->name('withdrawamount');
        Route::get('withdraw-funds', [WithdrawalController::class, 'withdrawfunds'])->name('withdrawfunds');
        Route::get('getotp', [WithdrawalController::class, 'getotp'])->name('getotp');
        Route::post('completewithdrawal', [WithdrawalController::class, 'completewithdrawal'])->name('completewithdrawal');

        // Subscription Trading
        Route::post('savemt4details', [UserSubscriptionController::class, 'savemt4details'])->name('savemt4details');
        Route::get('delsubtrade/{id}', [UserSubscriptionController::class, 'delsubtrade'])->name('delsubtrade');
        Route::get('renew/subscription/{id}', [UserSubscriptionController::class, 'renewSubscription'])->name('renewsub');

        // Investment, user buys plan
        Route::post('joinplan', [UserInvPlanController::class, 'joinplan'])->name('joinplan');
        Route::post('joininvestmentplan', [UserInvPlanController::class, 'joininvestmentplan'])->name('joininvestmentplan');

        // Route::post('changetheme', [SomeController::class, 'changetheme'])->name('changetheme');

        Route::post('paypalverify/{amount}', 'App\Http\Controllers\Controller@paypalverify')->name('paypalverify');
        Route::get('cpay/{amount}/{coin}/{ui}/{msg}', 'App\Http\Controllers\Controller@cpay')->name('cpay');
        Route::get('asset-balance', [ExchangeController::class, 'assetview'])->name('assetbalance');
        Route::get('swap-history', [ExchangeController::class, 'history'])->name('swaphistory');

        Route::get('asset-price/{base}/{quote}/{amount}', [ExchangeController::class, 'getprice'])->name('getprice');
        Route::post('exchange', [ExchangeController::class, 'exchange'])->name('exchangenow');
        Route::get('balances/{coin}', [ExchangeController::class, 'getBalance'])->name('getbalance');

        // USer to User transfer
        Route::post('transfertouser', [TransferController::class, 'transfertouser'])->name('transfertouser');

        // binance crypto payments routes
        Route::get('/binance/success', [ViewsController::class, 'binanceSuccess'])->name('bsuccess');
        Route::get('/binance/error', [ViewsController::class, 'binanceError'])->name('berror');


        //membership route for user side
        // Route::name('user.')->group(function () {
        //     Route::get('/courses', [MembershipController::class, 'courses'])->name('courses');
        //     Route::get('/course-details/{course}/{id}', [MembershipController::class, 'courseDetails'])->name('course.details');
        //     Route::post('/buy-course', [MembershipController::class, 'buyCourse'])->name('buycourse');
        //     Route::get('/my-courses', [MembershipController::class, 'myCourses'])->name('mycourses');
        //     Route::get('/course-details/{id}', [MembershipController::class, 'myCoursesDetails'])->name('mycoursedetails');
        //     Route::get('/learning/{lesson}/{course?}', [MembershipController::class, 'learning'])->name('learning');
        // });

        //signals
        Route::get('/trade-signals', [ViewsController::class, 'tradeSignals'])->name('tsignals');
        Route::get('/renew-subscription', [TransferController::class, 'renewSignalSub'])->name('renewsignals');
    });
});
Route::post('sendcontact', 'App\Http\Controllers\User\UsersController@sendcontact')->name('enquiry');

// Notification Routes
Route::middleware(['auth:sanctum', 'verified'])->prefix('notifications')->group(function () {
    Route::get('/', [UserNotificationController::class, 'index'])->name('notifications');
    Route::get('/{id}', [UserNotificationController::class, 'show'])->name('notifications.show');
    Route::post('/mark-read', [UserNotificationController::class, 'webMarkAsRead'])->name('notifications.mark-read');
    Route::post('/mark-all-read', [UserNotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');
    Route::delete('/delete', [UserNotificationController::class, 'webDeleteNotification'])->name('notifications.delete');
    Route::get('/count', [UserNotificationController::class, 'getUnreadCount'])->name('notifications.count');
});
