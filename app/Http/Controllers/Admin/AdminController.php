<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use Auth;
use App\Admin;
use Hash;


class AdminController extends  Controller
{

    //
    public function dashboard(){
    	return view('admin.admin_dashboard');
    }

    public function settings(){
     // echo "<pre>"; print_r(Auth::guard('admin')->user()); die;
      $adminDetails = Admin::where('email', Auth::guard('admin')->user()->email)->first();
      return view('admin.admin_settings')->with(compact('adminDetails'));
    }

    public function login(Request $request){
    	if($request->isMethod('post')){
    		$data = $request->all();
 //   		echo "<pre>"; print_r($data); die;

    		$rules = [
        		'email' => 'required|email|max:255',
        		'password' => 'required',
   			];

   			$customMessages = [
   				/*moze se postaviti bilo koja poruka */
   				'email.required' => 'Email is required',
   				'email.email' => 'Valid Email is required',
   				'password.required' => 'niste unijeli lozinku',
   					];
   			$this->validate($request,$rules,$customMessages);
// $rules, $request i $ customMessages moramo validirati da bi imalo efekta


    		if (Auth::guard('admin')->attempt(['email'=>$data['email'], 'password'=>$data['password']])){
				return redirect('admin/dashboard');
			}else{

	session::flash('error_message', 'Neispravan Email ili lozinka');
		return redirect()->back();
		}
    		}
//			TEST (HASHOVANJE)
//    	echo $password = Hash::make('12345678'); die;
    	return view('admin.admin_login');
    }
    public function logout(){
    	Auth::guard('admin')->logout();
    	return redirect('/admin');
    }
  

  public function chkCurrentPassword(Request $request){
    $data = $request->all();
 //   echo "<pre>"; print_r($data);
 //   echo "<pre>"; print_r(Auth::guard('admin')->user()->password); die;
    if(Hash::check($data['current_pwd'],Auth::guard('admin')->user()->password)){
        echo "true";
    }else{
        echo "false";
    }

   }
   public function updateCurrentPassword(Request $request){
    if($request->isMethod('post')){
      $data = $request->all();
    
    //      echo "<pre>"; print_r($data); die;

        //provjeravamo ispravnost lozinke, kao u prethodnom slucaju
       if(Hash::check($data['current_pwd'],Auth::guard('admin')->user()->password)){
       //provjeravamo da li se nova lozinka poklapa
       if($data['new_pwd']==$data['confirm_pwd']){
          Admin::where('id', Auth::guard('admin')->user()->id)->update(['password'=>bcrypt($data ['new_pwd'])]);
          Session::flash('success_message', 'Password has been updated successfully');
       }else{
        session::flash('error_message', 'new password and Confirm password not match');
       }

       }else{
        session::flash('error_message', 'Your current password is incorect');
       }
      return redirect()->back();
    }
  }
}


/*   		$validatedData = $request->validate([
        		'email' => 'required|email|max:255',
        		'password' => 'required',
   			]); */