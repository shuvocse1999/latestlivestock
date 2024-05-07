<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Staff;
use DB;
use Auth;

class StaffpaymentController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');

	}

	public function create()
	{
		$data['staff'] = Staff::where("designation","dsr")->get();
		return view("backend.staffpayment.create",$data);
	}


	public function getstaffdue($staff_id){


		$invoicedue = DB::table("sales_ledger")
		->where("staff_id",$staff_id)
		->sum("due");

		$paiddue = DB::table("sales_payment")
		->where("staff_id",$staff_id)
		->where("invoice_no","duepayment")
		->sum("payment");

		$discount = DB::table("sales_payment")
		->where("staff_id",$staff_id)
		->where("invoice_no","duepayment")
		->sum("discount");

		$due = $invoicedue - ($paiddue+$discount);

		return response()->json(number_format($due,2));


	}



	public function paymententry(Request $r){

		DB::table("sales_payment")->insert([
			'staff_id'      => $r->staff_id,
			'invoice_no'    => "duepayment",
			'payment_date'  => $r->date,
			'payment'       => $r->payment,
			'discount'      => $r->discount,
			'payment_type'  => $r->payment_type,
			'note'          => $r->note,
			'admin_id'      => Auth::user()->id,
			'created_at'    => now(),

		]);


		$notification=array(
			'messege'=>'DSR Payment Done',
			'alert-type'=>'success'
		);
		return Redirect()->back()->with($notification); 
	}

	public function index(){

		$data = DB::table("sales_payment")
		->where("sales_payment.invoice_no","duepayment")
		->orderBy("sales_payment.id",'DESC')
		->join('staff','staff.id','sales_payment.staff_id')
		->select("sales_payment.*",'staff.staff_name')
		->get();

		return view("backend.staffpayment.index",compact('data'));
	}

	public function deletestaffpayment($id){

		DB::table("sales_payment")
		->where("id",$id)
		->delete();


		$notification=array(
			'messege'=>'Payment Delete Done',
			'alert-type'=>'success'
		);
		return Redirect()->back()->with($notification); 
	}


	

}
