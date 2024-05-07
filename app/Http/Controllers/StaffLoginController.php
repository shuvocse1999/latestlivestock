<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Auth;

class StaffLoginController extends Controller
{
	public function stafflogin(){

		return view('backend.stafflogin.login');
	}


	public function staffloginnow(Request $request)
	{
		$session_id = Session::getId();

		$creadential=['phone'=>$request->phone,'password'=>$request->password];

		if (Auth::guard('guest')->attempt($creadential)) 
		{

			$notification=array(
				'messege'   =>'Login Successfully Done',
				'alert-type'=>'success'
			);

			return redirect('/staffdashboard')->with($notification); 


		}
		else{
			return redirect()->back();
		}

	}
}
