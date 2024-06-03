<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class ReportsController extends Controller
{

	public function __construct()
	{
		$this->middleware('auth');

	}


	public function stockreports(){

		$data['category'] = DB::table("categories")->get();

		return view("backend.reports.stockreports",$data);
	}



	public function searchstockreports(Request $r){

		$category  = $r->category_id;
		$from_date = $r->from_date;
		$to_date   = $r->to_date;

		$startdate = "2024-03-01";



		if ($category == "all") {

			$product = DB::table("products")
			->get();

		}else{

			$product = DB::table("products")
			->where('category_id',$r->category_id)
			->get();

		}

		return view("backend.reports.searchstockreports",compact('product','from_date','to_date','startdate'));
	}



	public function dsrreports(){

		$data['staff'] = DB::table("staff")->get();

		return view("backend.reports.dsrreports",$data);
	}



	public function searchdsrreports(Request $r){

		$staff     = $r->staff_id;
		$from_date = $r->from_date;
		$to_date   = $r->to_date;

		if ($staff == "all") {

			if ($from_date == null && $to_date == null) {
				$ledger = DB::table("sales_ledger")
				->join('staff','staff.id','sales_ledger.staff_id')
				->select("sales_ledger.*",'staff.staff_name')
				->get();

				$duepayment = DB::table("sales_payment")
				->where("sales_payment.invoice_no","duepayment")
				->orderBy("sales_payment.id",'DESC')
				->join('staff','staff.id','sales_payment.staff_id')
				->select("sales_payment.*",'staff.staff_name')
				->get();

			}else{


				if ($to_date == null) {
					$ledger = DB::table("sales_ledger")
					->whereDate('sales_ledger.invoice_date',$r->from_date)
					->join('staff','staff.id','sales_ledger.staff_id')
					->select("sales_ledger.*",'staff.staff_name')
					->get();

					$duepayment = DB::table("sales_payment")
					->where("sales_payment.invoice_no","duepayment")
					->whereDate('sales_payment.payment_date',$r->from_date)
					->orderBy("sales_payment.id",'DESC')
					->join('staff','staff.id','sales_payment.staff_id')
					->select("sales_payment.*",'staff.staff_name')
					->get();


				}else{

					$ledger = DB::table("sales_ledger")
					->whereBetween('sales_ledger.invoice_date',array($from_date,$to_date))
					->join('staff','staff.id','sales_ledger.staff_id')
					->select("sales_ledger.*",'staff.staff_name')
					->get();

					$duepayment = DB::table("sales_payment")
					->where("sales_payment.invoice_no","duepayment")
					->whereBetween('sales_payment.payment_date',array($from_date,$to_date))
					->orderBy("sales_payment.id",'DESC')
					->join('staff','staff.id','sales_payment.staff_id')
					->select("sales_payment.*",'staff.staff_name')
					->get();
				}
			}

			

		}else{

			
			if ($from_date == null && $to_date == null) {
				$ledger = DB::table("sales_ledger")
				->where("sales_ledger.staff_id",$staff)
				->join('staff','staff.id','sales_ledger.staff_id')
				->select("sales_ledger.*",'staff.staff_name')
				->get();

				$duepayment = DB::table("sales_payment")
				->where("sales_payment.invoice_no","duepayment")
				->where("sales_payment.staff_id",$staff)
				->orderBy("sales_payment.id",'DESC')
				->join('staff','staff.id','sales_payment.staff_id')
				->select("sales_payment.*",'staff.staff_name')
				->get();

			}else{

				if ($to_date == null) {
					$ledger = DB::table("sales_ledger")
					->where("sales_ledger.staff_id",$staff)
					->whereDate('sales_ledger.invoice_date',$r->from_date)
					->join('staff','staff.id','sales_ledger.staff_id')
					->select("sales_ledger.*",'staff.staff_name')
					->get();

					$duepayment = DB::table("sales_payment")
					->where("sales_payment.invoice_no","duepayment")
					->whereDate('sales_payment.payment_date',$r->from_date)
					->where("sales_payment.staff_id",$staff)
					->orderBy("sales_payment.id",'DESC')
					->join('staff','staff.id','sales_payment.staff_id')
					->select("sales_payment.*",'staff.staff_name')
					->get();


				}else{
					$ledger = DB::table("sales_ledger")
					->where("sales_ledger.staff_id",$staff)
					->whereBetween('sales_ledger.invoice_date',array($from_date,$to_date))
					->join('staff','staff.id','sales_ledger.staff_id')
					->select("sales_ledger.*",'staff.staff_name')
					->get();

					$duepayment = DB::table("sales_payment")
					->where("sales_payment.invoice_no","duepayment")
					->whereBetween('sales_payment.payment_date',array($from_date,$to_date))
					->where("sales_payment.staff_id",$staff)
					->orderBy("sales_payment.id",'DESC')
					->join('staff','staff.id','sales_payment.staff_id')
					->select("sales_payment.*",'staff.staff_name')
					->get();
				}
			}
		}

		

		return view("backend.reports.searchdsrreports",compact('from_date','to_date','ledger','duepayment'));
	}



	public function profitreports(){

		$dsr = DB::table("staff")->get();

		return view("backend.reports.profitreports");
	}


	public function searchprofitreports(Request $r){

		$from_date = $r->from_date;
		$to_date   = $r->to_date;


		if ($to_date == null) {
			$data['recieved'] = DB::table("purchase_payment")
			->whereDate('payment_date',$from_date)
			->get();

			$data['sales'] = DB::table("products")
			->get();

			$tcost = DB::table("sales_ledger")
			->whereDate('invoice_date',$from_date)
			->sum('transport_cost');

			$dcost = DB::table("sales_ledger")
			->whereDate('invoice_date',$from_date)
			->sum('dsr_cost');


			$data['income'] = DB::table("incomeexpense")
			->whereDate('dates',$from_date)
			->where("type","income")
			->get();

			$data['expense'] = DB::table("incomeexpense")
			->whereDate('dates',$from_date)
			->where("type","expense")
			->get();

		}
		else{

			$data['recieved'] = DB::table("purchase_payment")
			->whereBetween('payment_date',array($from_date,$to_date))
			->get();

			$data['sales'] = DB::table("products")
			->get();

			

			$tcost = DB::table("sales_ledger")
			->whereBetween('invoice_date',array($from_date,$to_date))
			->sum('transport_cost');

			$dcost = DB::table("sales_ledger")
			->whereBetween('invoice_date',array($from_date,$to_date))
			->sum('dsr_cost');


			$data['income'] = DB::table("incomeexpense")
			->whereBetween('dates',array($from_date,$to_date))
			->where("type","income")
			->get();

			$data['expense'] = DB::table("incomeexpense")
			->whereBetween('dates',array($from_date,$to_date))
			->where("type","expense")
			->get();
		}

		


		return view("backend.reports.searchprofitreports",compact('data','from_date','to_date','tcost','dcost'));

		
	}
	


	public function dsrstockreportsbyadmin(){

		$dsr = DB::table("staff")->get();

		return view("backend.reports.dsrstockreportsbyadmin",compact('dsr'));
	}






	public function searchdsrstockreportsbyadmin(Request $r){

		$product = DB::table("products")
		->get();

		$dsr_id = $r->staff_id;
		$staff_name = DB::table("staff")->where('id',$r->staff_id)->first();

		return view("backend.reports.searchdsrstockreportsbyadmin",compact('product','dsr_id','staff_name'));
	}



	


}
