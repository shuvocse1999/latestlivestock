<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class StockController extends Controller
{
   public function __construct()
	{
		$this->middleware('auth');

	}


	public function index(){

		$data['product'] = DB::table("products")
		->get();

		return view("backend.stock.stock",$data);
	}
}
