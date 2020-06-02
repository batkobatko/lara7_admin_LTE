<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// use Hash;
use Auth;
use Session;


class AdminController extends Controller
{
    //
    public function dashboard(){
    	return view('admin.admin_dashboard');
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
}




/*   		$validatedData = $request->validate([
        		'email' => 'required|email|max:255',
        		'password' => 'required',
   			]); */