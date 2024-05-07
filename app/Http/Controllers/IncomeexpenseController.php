<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;

class IncomeexpenseController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');

	}

	public function create(){

		return view("backend.incomeexpense.create");
	}

	public function store(Request $r){

		DB::table("incomeexpense")->insert([

			'dates'      => $r->date,
			'type'       => $r->type,
			'title'      => $r->title,
			'amount'     => $r->amount,
			'created_at' => now(),
		]);


		$notification=array(
			'messege'=>'Income/Expense Entry Done',
			'alert-type'=>'success'
		);
		return Redirect()->back()->with($notification); 
	}


	public function index(){

		$data['expense'] = DB::table("incomeexpense")->orderBy('id','DESC')->where("type","expense")->get();
		$data['income']  = DB::table("incomeexpense")->orderBy('id','DESC')->where("type","income")->get();

		return view("backend.incomeexpense.index",$data);
	}



	public function delete($id){

		DB::table("incomeexpense")->where('id',$id)->delete();

		$notification=array(
			'messege'=>'Income/Expense Delete Done',
			'alert-type'=>'success'
		);
		return Redirect()->back()->with($notification); 
	}



}
