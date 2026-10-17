<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Settings;
use App\Models\Plans;
use App\Models\SettingsCont;
use App\Models\Agent;
use App\Models\Mt4Details;
use App\Models\Admin;
use App\Models\User_copytradings;
use App\Models\Copytrading;
use App\Models\Cp_transaction;
use App\Models\Tp_Transaction;
use Illuminate\Support\Facades\DB;



class Copytradingcontroller extends Controller
{
    function copytrading(){
        $copytradings = Copytrading::where('type', 'Main')->orderby('created_at','ASC')->get();
        return view('admin.copytrading.copytrading')->with(array(
            'copytradings'=> $copytradings,
            'title'=>'User copytrading Plan(s)',));
    }



    public function newcopytrading()
    {
    	return view('admin.copytrading.newcopytrading')
        ->with(array(
        'title'=>'Add New Copy Trading Plan',
        
        ));
    }

    public function editcopytrading($id)
    {
    	return view('admin.copytrading.editcopytrading')
        ->with(array(
        'title'=>'Edit Copy trading',
        'copytrading'=> Copytrading::where('id', $id)->first(),
        
        ));
    }


    public function addcopytrading(Request $request){
       
        $this->validate($request, [
            'photo' => 'mimes:jpg,jpeg,png|max:500|image',
             
              
           
            
          ]);
        
        $settings = Settings::where('id', '=', '1')->first();

        if ($request->hasfile('photo')) {

           
            $file = $request->file('photo');
            $extension = $file->extension();
            $whitelist = array('pdf', 'doc', 'jpeg', 'jpg', 'png');
            
           
            if (in_array($extension, $whitelist)) {
                $path = $file->store('uploads', 'public');
            } else {
                return redirect()->back()
                    ->with('message', 'Unaccepted Image Uploaded');
            }
        }
     
       
        $plan=new Copytrading();
        $plan->tag= $request['tag'];
        $plan->name= $request['name'];
        $plan->followers= $request['followers'];
        $plan->total_profit= $request['total_profit'];
        $plan->button_name=$request['button_name'];
        $plan->active_days=$request['active_days'];
        $plan->equity=$request['equity'];
        $plan->price= $request['price'];
        $plan->rating= $request['rating'];
        $plan->photo= $path;
        $plan->type= 'Main';
        $plan->save();
        return redirect()->back()->with('success', 'Copy trade created Sucessfully!');
    }


    //Update plan
    public function updatecopytrading(Request $request){

        if ($request->hasfile('photo')) {

           
            $file = $request->file('photo');
            $extension = $file->extension();
            $whitelist = array('pdf', 'doc', 'jpeg', 'jpg', 'png');
            
           
            if (in_array($extension, $whitelist)) {
                $path = $file->store('uploads', 'public');
            } else {
                return redirect()->back()
                    ->with('message', 'Unaccepted Image Uploaded');
            }
        }
          $copytrading = Copytrading::where('id', $request['id'])->first();
         
          if(empty($request->photo)){
            $path=  $copytrading->photo;
          }else{
            $path =  $path;
          }
        Copytrading::where('id', $request['id'])
        ->update([
        'tag'=> $request['tag'],
        'name'=> $request['name'],
        'followers'=> $request['followers'],
        'total_profit'=> $request['total_profit'],
       'button_name'=>$request['button_name'],
        'active_days'=>$request['active_days'],
        'equity'=>$request['equity'],
        'price'=> $request['price'],
       'rating'=> $request['rating'],
       'photo'=> $path,
       'type'=> 'Main',
        ]);
        return redirect()->back()->with('success', 'Copytrading Plan Successfully Updated');
    }

    //Trash Plans route
    public function trashcopytrading($id){
        
        // Delete this plan from every user account that have bought this plan
        $userscopytradings = User_copytradings::where('cptrading', $id)->get();
        if (count( $userscopytradings) > 0) {
            foreach( $userscopytradings as $cpls){
                User_copytradings::where('id', $cpls->id)->delete(); 
            }

       
        }

        

         //remove users from the plan before deleting
        
         $users=User::where('copy', Copytrading::where('id',$id)->first()->name)->get();
         foreach($users as $user){
             User::where('id',$user->id)
             ->update([
                 'copy' =>  NULL,
                 'copy_plan' =>NULL,
                 //'confirmed_plan' => 0,
             ]);  
         }
         Copytrading::where('id',$id)->delete();
         return redirect()->back()
         ->with('success', 'Copy trading deleted Successfully!');
    }
   

    public function activecopytrading(){
        return view('admin.copytrading.activecopytrading',[
            'title' => 'Active Trade copying',
            'copytrades' => User_copytradings::where('active', 'yes')->orderByDesc('id')->with(['dcopytrading', 'cuser'])->get(),
        ]);
    }
           public function tradingprogress(Request $request){
            User::where('id',$request->user_id)->update([
                'progress'=> $request->progress ,
            ]);

            return redirect()->back()
            ->with('success', 'Trading Progress updated ');
           }
}
