<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;
use DB;
use Auth;

class ShoppaymentController extends Controller
{
	public function __construct()
	{
		$this->middleware('guestauth');

	}

	public function create()
	{
		$data['shop'] = Shop::get();
		return view("backend.staffdashboard.shoppayment.create",$data);
	}


	public function getshopdue($shop_id){


		$invoicedue = DB::table("dsrsales_ledger")
		->where("shop_id",$shop_id)
		->sum("due");

		$paiddue = DB::table("dsrsales_payment")
		->where("shop_id",$shop_id)
		->where("invoice_no","duepayment")
		->sum("payment");

		$discount = DB::table("dsrsales_payment")
		->where("shop_id",$shop_id)
		->where("invoice_no","duepayment")
		->sum("discount");

		$due = $invoicedue - ($paiddue+$discount);

		return response()->json(number_format($due,2));


	}



	public function shoppaymententry(Request $r){

		DB::table("dsrsales_payment")->insert([
			'staff_id'         => Auth('guest')->user()->id,
			'shop_id'      => $r->shop_id,
			'invoice_no'    => "duepayment",
			'payment_date'  => $r->date,
			'payment'       => $r->payment,
			'discount'      => $r->discount,
			'payment_type'  => $r->payment_type,
			'note'          => $r->note,
			'admin_id'      => "",
			'created_at'    => now(),

		]);


		$notification=array(
			'messege'=>'Shop Payment Done',
			'alert-type'=>'success'
		);
		return Redirect()->back()->with($notification); 
	}

	public function index(){

		$data = DB::table("dsrsales_payment")
		->where("dsrsales_payment.invoice_no","duepayment")
		->orderBy("dsrsales_payment.id",'DESC')
		->join('shops','shops.id','dsrsales_payment.shop_id')
		->select("dsrsales_payment.*",'shops.shop_name')
		->get();

		return view("backend.staffdashboard.shoppayment.index",compact('data'));
	}

	public function deleteshoppayment($id){

		DB::table("dsrdsrsales_payment")
		->where("id",$id)
		->delete();


		$notification=array(
			'messege'=>'Payment Delete Done',
			'alert-type'=>'success'
		);
		return Redirect()->back()->with($notification); 
	}


	

}
