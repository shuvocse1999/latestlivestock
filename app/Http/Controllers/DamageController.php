<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;

class DamageController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');

	}

	public function create(){

		$product = DB::table("products")->get();

		return view("backend.damage.create",compact('product'));
	}


	public function insert(Request $r){

		$product = DB::table("products")->where("id",$r->product_id)->first();


		DB::table("stocks")->insert([
			'product_id'      => $r->product_id,
			'invoice_no'      => "damage",
			'damage'          => $r->damage,
			'purchase_price'  => $product->purchase_price,
			'sales_price'     => $product->sales_price,
			'admin_id'        => Auth::user()->id,
			'created_at'      => $r->date,

		]);


		$notification=array(
			'messege'=>'Damage Product Added Done',
			'alert-type'=>'success'
		);
		return Redirect()->back()->with($notification); 

	}



	public function damagereports(){

		$cat['category'] = DB::table("categories")->get();

		return view("backend.damage.damagereports",$cat);
	}




	public function searchdamagereports(Request $r){

		$category  = $r->category_id;
		$startdate = $r->from_date;
		$to_date   = $r->to_date;

		if ($category == "all") {

			$product = DB::table("products")
			->get();

		}else{

			$product = DB::table("products")
			->where('category_id',$r->category_id)
			->get();

		}

		return view("backend.damage.searchdamagereports",compact('product','startdate','to_date'));
	}



}
