<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Settings;
use App\Models\Plans;
use App\Models\Tp_Transaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Mail\NewNotification;
use App\Models\User_plans;
use App\Models\Loan;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class LoanController extends Controller
{

    public function loan(Request $request){
        //get user
        $user=User::where('id',Auth::user()->id)->first();
        //get plan


        //save user laon
        $userplanid = DB::table('loans')->insertGetId([

            'user' => Auth::user()->id,
            'amount' => $request['amount'],
            'income'=> $request['income'],
            'purpose'=> $request['purpose'],
            'duration'=>$request['duration'],
            'facility' => $request['facility'],
            'active' => 'Pending',
            'inv_duration'=>$request['duration'],
            'activated_at' => \Carbon\Carbon::now(),
            'last_growth' => \Carbon\Carbon::now(),
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);



        // send notification
        $settings=Settings::where('id', '=', '1')->first();
        $message = "This is to inform you that $user->name just applied for a loan plan for $request->purpose";
        $subject ="Loan Application by $user->name ";

        try {
            Mail::to($settings->contact_email)->send(new NewNotification($message, $subject, 'Admin'));
        } catch (\Exception $e) {
            \Log::error('Failed to send loan application notification email. User: ' . $user->name . ' (' . $user->email . '), Loan ID: ' . $userplanid . ', Purpose: ' . $request->purpose . '. Error: ' . $e->getMessage());
        }

        return redirect()->back()
          ->with('success', "You have successfully applied for a loan your loan is currently pending, you will be contacted soon.");
    }


    public function veiwloans(){

        $loans = Loan::where('user', Auth::user()->id)->orderByDesc('id')->get();
        $title = 'Applied Loans';
        return view('user.loans', [
            'loans'=>$loans, 'title'=>$title,

    ]);
    }

}
