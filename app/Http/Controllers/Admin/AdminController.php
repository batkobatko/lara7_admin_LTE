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
}


/*   		$validatedData = $request->validate([
        		'email' => 'required|email|max:255',
        		'password' => 'required',
   			]); */