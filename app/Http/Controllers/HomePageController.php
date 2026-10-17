<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Settings;
use App\Models\Plans;
use App\Models\Agent;
use App\Models\User_plans;
use App\Models\Admin;
use App\Models\Faq;
use App\Models\Images;
use App\Models\Testimony;
use App\Models\Content;
use App\Models\Asset;
use Illuminate\Support\Facades\Validator;
use App\Models\Mt4Details;
use App\Models\Deposit;
use App\Models\Wdmethod;
use App\Models\Withdrawal;
use App\Models\Cp_transaction;
use App\Models\TermsPrivacy;
use App\Models\Tp_Transaction;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Mail\NewNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class HomePageController extends Controller
{
    public function index(){
        $settings=Settings::where('id', '=', '1')->first();
        //sum total deposited
        $total_deposits = DB::table('deposits')->select(DB::raw("SUM(amount) as total"))->
        where('status','Processed')->get();

        //sum total withdrawals
        $total_withdrawals = DB::table('withdrawals')->select(DB::raw("SUM(amount) as total"))->
        where('status','Processed')->get();

        $btcStats = $this->getBitcoinStats();

        return view('home.index')->with(array(
            'settings' => $settings,
            'total_users' => User::count(),
            'plans' => Plans::all(),
            'total_deposits' => $total_deposits,
            'total_withdrawals' => $total_withdrawals,
            'faqs'=> Faq::orderby('id', 'desc')->get(),
            'test'=> Testimony::orderby('id', 'desc')->get(),
            'withdrawals' => Withdrawal::orderby('id','DESC')->take(7)->get(),
            'deposits' => Deposit::orderby('id','DESC')->take(7)->get(),
            'title' => $settings->site_title,
             'btcStats' => $btcStats,
            'mplans' => Plans::where('type','Main')->get(),
            'pplans' => Plans::where('type','Promo')->get(),
        ));
    }

    //Licensing and registration route
    public function licensing(){

        return view('home.licensing')
        ->with(array(
            'mplans' => Plans::where('type','Main')->get(),
            'pplans' => Plans::where('type','Promo')->get(),
            'title' => 'Licensing, regulation and registration',
            'settings' => Settings::where('id', '=', '1')->first(),
        ));
    }

    //Terms of service route
    public function terms(){

        return view('home.terms')
        ->with(array(
            'mplans' => Plans::where('type','Main')->get(),
            'title' => 'Terms of Service',
            'settings' => Settings::where('id', '=', '1')->first(),
        ));
    }

    //Privacy policy route
    public function privacy(){
        $terms = TermsPrivacy::find(1);

        return view('home.privacy')
        ->with(array(
            'mplans' => Plans::where('type','Main')->get(),
            'title' => 'Privacy Policy',
            'settings' => Settings::where('id', '=', '1')->first(),
        ));
    }

    //FAQ route
    public function faq(){

        return view('home.faq')
        ->with(array(
            'title' => 'FAQs',
            'faqs'=> Faq::orderby('id', 'desc')->get(),
            'settings' => Settings::where('id', '=', '1')->first(),
        ));
    }

   //why-us
    public function whyus(){

        return view('home.whyus')
        ->with(array(
            'title' => 'why-us',

            'settings' => Settings::where('id', '=', '1')->first(),
        ));
    }
    //ETFS
     public function etfs(){

        return view('home.etfs')
        ->with(array(
            'title' => 'ETFS',

            'settings' => Settings::where('id', '=', '1')->first(),
        ));
    }


  public function copy(){

        return view('home.copy')
        ->with(array(
            'title' => 'copy',

            'settings' => Settings::where('id', '=', '1')->first(),
        ));
    }

  public function trade(){

        return view('home.trade')
        ->with(array(
            'title' => 'trade',

            'settings' => Settings::where('id', '=', '1')->first(),
        ));
    }

   public function automate(){

        return view('home.automate')
        ->with(array(
            'title' => 'automate',

            'settings' => Settings::where('id', '=', '1')->first(),
        ));
    }

    //ETFS
     public function   indices(){

        return view('home.indices')
        ->with(array(
            'title' => 'Indices',

            'settings' => Settings::where('id', '=', '1')->first(),
        ));
    }

     //Nfts
     public function   nfts(){

        return view('home.nfts')
        ->with(array(
            'title' => 'NFTS',

            'settings' => Settings::where('id', '=', '1')->first(),
        ));
    }

    public function   shares(){

        return view('home.shares')
        ->with(array(
            'title' => 'Shares',

            'settings' => Settings::where('id', '=', '1')->first(),
        ));
    }


    //Forex
     public function forex(){

        return view('home.forex')
        ->with(array(
            'title' => 'Forex',

            'settings' => Settings::where('id', '=', '1')->first(),
        ));
    }

     public function regulation(){

        return view('home.regulation')
        ->with(array(
            'title' => ' regulation',

            'settings' => Settings::where('id', '=', '1')->first(),
        ));
    }


 //fortrader route
     public function fortrader(){

        return view('home.fortrader')
        ->with(array(
            'title' => 'for-trader',

            'settings' => Settings::where('id', '=', '1')->first(),
        ));
    }
///cryptocurrencies



 public function cryptocurrencies(){

        return view('home.cryptocurrencies')
        ->with(array(
            'title' => 'cryptocurrencies',

            'settings' => Settings::where('id', '=', '1')->first(),
        ));
    }
///trading-conditions
 public function trading_conditions(){

        return view('home.trading-conditions')
        ->with(array(
            'title' => 'trading conditions',

            'settings' => Settings::where('id', '=', '1')->first(),
        ));
    }
    //about route
    public function about(){

        return view('home.about')
        ->with(array(
            'mplans' => Plans::where('type','Main')->get(),

            'title' => 'About',
            'settings' => Settings::where('id', '=', '1')->first(),
        ));
    }

    //Contact route
    public function contact(){
        return view('home.contact')
        ->with(array(
            'mplans' => Plans::where('type','Main')->get(),
                'pplans' => Plans::where('type','Promo')->get(),

            'title' => 'Contact',
            'settings' => Settings::where('id', '=', '1')->first(),
        ));
    }



    //send contact message to admin email
    public function sendcontact(Request $request){

        $settings=Settings::where('id','1')->first();
        $objDemo = new \stdClass();
        $objDemo->message = substr(wordwrap($request['message'],70),0,350);
        $objDemo->sender = "$settings->site_name";
        $objDemo->date = \Carbon\Carbon::Now();
        $objDemo->subject = "$request->subject,  my email $request->email";

        try {
            Mail::bcc($settings->contact_email)->send(new NewNotification($objDemo));
        } catch (\Exception $e) {
            \Log::error('Failed to send contact email notification. Subject: ' . $request->subject . ', Email: ' . $request->email . '. Error: ' . $e->getMessage());
        }

        return redirect()->back()
        ->with('success', ' Your message was sent successfully!');
    }

    /**
     * Fetch Bitcoin statistics from CoinGecko API
     *
     * @return array
     */
    private function getBitcoinStats()
    {
        try {
            $response = Http::get('https://api.coingecko.com/api/v3/coins/bitcoin');

            if ($response->successful()) {
                $data = $response->json();

                return [
                    'price' => $data['market_data']['current_price']['usd'],
                    'volume_24h' => $data['market_data']['total_volume']['usd'],
                    'ath' => $data['market_data']['ath']['usd'],
                    'circulating_supply' => $data['market_data']['circulating_supply'],
                    'change_24h_percent' => $data['market_data']['price_change_percentage_24h'],
                    'market_cap' => $data['market_data']['market_cap']['usd'],
                ];
            }
        } catch (\Exception $e) {
            // Log error or handle as needed
            \Log::error('Failed to fetch Bitcoin stats: ' . $e->getMessage());
        }

        // Return default values if API call fails
        return [
            'price' => 0,
            'volume_24h' => 0,
            'ath' => 0,
            'circulating_supply' => 0,
            'change_24h_percent' => 0,
            'market_cap' => 0,
        ];
    }
}
