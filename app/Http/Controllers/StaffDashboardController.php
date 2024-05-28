<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Staff;
use App\Models\Product;
use App\Models\Shop;
use Session;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class StaffDashboardController extends Controller
{
	public function __construct()
	{
		$this->middleware('guestauth');

	}

	public function staffdashboard(){
		
		return view('backend.staffdashboard.dashboard');
	}

	public function stafflogout(){

		Auth::guard('guest')->logout();
		return redirect('stafflogin');
	}




	public function dsrproductrecivedlist(){



		$data = DB::table('sales_ledger')
		->join("staff",'staff.id','sales_ledger.staff_id')
		->select("sales_ledger.*",'staff.staff_name')
		->orderBy('sales_ledger.id','DESC')
		->where('sales_ledger.status',1)
		->where('sales_ledger.staff_id',Auth('guest')->user()->id)
		->get();


		return view("backend.staffdashboard.dsrpurchase.index",compact('data'));

		
	}


	
	public function dsrpurchaseinvoice($invoice_no){

		$data = DB::table('sales_ledger')
		->where("sales_ledger.invoice_no",$invoice_no)
		->join("staff",'staff.id','sales_ledger.staff_id')
		->select("sales_ledger.*",'staff.staff_name')
		->first();

		$product = DB::table("sales_entry")
		->where("sales_entry.invoice_no",$data->invoice_no)
		->join("products",'products.id','sales_entry.product_id')
		->select("sales_entry.*",'products.product_name')
		->get();

		return view("backend.staffdashboard.dsrpurchase.dsrpurchaseinvoice",compact('data','product'));
	}




	public function create()
	{
		$data['category'] = Category::get();
		$data['brand']    = Brand::get();
		$data['product']  = Product::get();
		$data['shop']  = Shop::get();

		return view("backend.staffdashboard.dsrsales.create",$data);

	}




	public function showdsrsalescurrentcart(){
		$session_id   = Session::getId();

		$data['product'] = DB::table('sales_current')
		->where('sales_current.session_id',$session_id)
		->join('products','products.id','sales_current.product_id')
		->select('sales_current.*','products.product_name')
		->get();

		return view('backend.staffdashboard.dsrsales.showdsrsalescurrentcart',$data);
	}



	public function salesdsrcurrentcart(Request $request,$id)
	{

		$session_id   = Session::getId();
		$checkproduct = DB::table('products')->where('id',$id)->first();


		$checkaddproduct = DB::table('sales_current')
		->where('session_id',$session_id)
		->where('product_id',$id)
		->first();

		if ($checkaddproduct) 
		{

			dd("Product Already Added");


		}
		else
		{

			DB::table('sales_current')->insert([
				'product_id'         => $id,
				'purchase_price'     => $checkproduct->purchase_price,
				'sales_price'        => $checkproduct->sales_price,
				'session_id'         => $session_id,
				'admin_id'           => " ",
				'created_at'         => now(),
			]);

		}



	}




	public function dsrsalescartonupdate(Request $request,$id){

		$session_id   = Session::getId();

		$data = DB::table('sales_current')
		->where('session_id',$session_id)
		->where('id',$id)
		->update([

			'carton' => $request->carton

		]);


	}
	


	public function dsrsalespieceupdate(Request $request,$id){

		$session_id   = Session::getId();
		$data = DB::table('sales_current')
		->where('session_id',$session_id)
		->where('id',$id)
		->update([

			'piece' => $request->piece

		]);

	}
	


	public function dsrsalespriceupdate(Request $request,$id){

		$session_id   = Session::getId();
		$data = DB::table('sales_current')
		->where('session_id',$session_id)
		->where('id',$id)
		->update([

			'sales_price' => $request->price

		]);

	}







	public function dsrsalesledger(Request $request){



		$session_id   = Session::getId();
		$data = DB::table('sales_current')
		->where('session_id',$session_id)
		->get();

		$invoice_no = IdGenerator::generate(['table' => 'dsrsales_ledger', 'field'=>'invoice_no','length' => 10, 'prefix' =>'DSI-']);


		foreach ($data as $d) {

			$unit = DB::table("products")->where("id",$d->product_id)->first();

			$checkqty = ($unit->unit_per_group*$d->carton)+$d->piece;

			

			DB::table("dsrsales_entry")->insert([
				'invoice_no'        => $invoice_no,
				'product_id'        => $d->product_id,
				'carton'            => $d->carton,
				'piece'             => $d->piece,
				'qty'               => ($unit->unit_per_group*$d->carton)+$d->piece,
				'free'              => $d->free,
				'returnscarton'     => $d->returnscarton,
				'returnspiece'      => $d->returnspiece,
				'returnsqty'        => ($unit->unit_per_group*$d->returnscarton)+$d->returnspiece,
				'damage'            => $d->damage,
				'purchase_price'    => $d->purchase_price,
				'sales_price'       => $d->sales_price,
				'session_id'        => $d->session_id,
				'admin_id'          => "",
				'created_at'        => now(),

			]);


			DB::table("dsrstocks")->insert([
				'invoice_no'         => $invoice_no,
				'staff_id'           => Auth('guest')->user()->id,
				'product_id'         => $d->product_id,
				'carton'             => $d->carton,
				'piece'              => $d->piece,
				'qty'                => ($unit->unit_per_group*$d->carton)+$d->piece,
				'free'               => $d->free,
				'sales_return'       => ($unit->unit_per_group*$d->returnscarton)+$d->returnspiece,
				'returnqty'          => ($unit->unit_per_group*$d->returnscarton)+$d->returnspiece,
				'returncarton'       => $d->returnscarton,
				'returnpiece'        => $d->returnspiece,
				'damage'             => $d->damage,
				'purchase_price'     => $d->purchase_price,
				'sales_price'        => $d->sales_price,
				'admin_id'           => "",
				'created_at'         => $request->invoice_date,

			]);

			
			

		}  


		if ($request->salestype == 0) {
			DB::table("dsrsales_ledger")->insert([
				'staff_id'         => Auth('guest')->user()->id,
				'invoice_date'     => $request->invoice_date,
				'invoice_no'       => $invoice_no,
				'shop_id'          => $request->shop_id,
				'shop_number'      => " ",
				'market'           => $request->market,
				'total'            => $request->totalamount,
				'discount'         => $request->discount,
				'transport_cost'   => $request->transport_cost,
				'dsr_cost'         => $request->dsr_cost,
				'grandtotal'       => $request->grandtotal,
				'paid'             => $request->paid,
				'due'              => $request->due,
				'transaction_type' => $request->transaction_type,
				'status'           => "1",
				'admin_id'         => "",
				'created_at'       => now(),

			]);
		}else{

			DB::table("dsrsales_ledger")->insert([
				'staff_id'         => Auth('guest')->user()->id,
				'invoice_date'     => $request->invoice_date,
				'invoice_no'       => $invoice_no,
				'shop_id'          => $request->shop_id,
				'shop_number'      => " ",
				'market'           => $request->market,
				'total'            => $request->totalamount,
				'discount'         => $request->discount,
				'transport_cost'   => $request->transport_cost,
				'dsr_cost'         => $request->dsr_cost,
				'grandtotal'       => $request->grandtotal,
				'paid'             => $request->paid,
				'due'              => $request->due,
				'transaction_type' => $request->transaction_type,
				'admin_id'         => "",
				'created_at'       => now(),
				]);

		}


		


		DB::table("dsrsales_payment")->insert([
			'invoice_no'       => $invoice_no,
			'staff_id'         => Auth('guest')->user()->id,
			'shop_id'          => $request->shop_id,
			'payment_date'     => $request->invoice_date,
			'payment'          => $request->paid,
			'discount'         => $request->discount,
			'opening_balance'  => null,
			'payment_type'     => $request->transaction_type,
			'note'             => "firstpayment",
			'admin_id'         => "",
			'created_at'       => now(),


		]);


		DB::table('sales_current')->where('session_id',$session_id)->delete();
		Session::regenerate();

		return response()->json($invoice_no);


	}



	public function dsreditsales($id){

		$data['sales'] = DB::table("dsrsales_ledger")->where("id",$id)->first();


		if ($data['sales']->status == "1") {

			$notification=array(
				'messege'=>'Invoice Confirm Done',
				'alert-type'=>'success'
			);
			return Redirect()->back()->with($notification); 

			
		}else{

			$data['category'] = Category::get();
			$data['brand']    = Brand::get();
			$data['shop']    = Shop::get();
			$data['product']  = Product::get();

			return view("backend.staffdashboard.dsrsales.dsreditsales",$data);

			


		}

		
	}




	public function showeditdsrsalescurrentcart($invoice_no){


		$data['product'] = DB::table('dsrsales_entry')
		->where('dsrsales_entry.invoice_no',$invoice_no)
		->join('products','products.id','dsrsales_entry.product_id')
		->select('dsrsales_entry.*','products.product_name')
		->get();


		return view('backend.staffdashboard.dsrsales.showeditdsrsalescurrentcart',$data);
	}


	




	public function editdsrsalesledger(Request $request,$invoice_no){


		if ($request->status == 1) {
			DB::table("dsrsales_ledger")->where('invoice_no',$invoice_no)->update([

				'staff_id'         => Auth('guest')->user()->id,
				'invoice_date'     => $request->invoice_date,
				'invoice_no'       => $invoice_no,
				'shop_id'          => $request->shop_id,
				'shop_number'      => " ",
				'market'           => $request->market,
				'total'            => $request->totalamount,
				'discount'         => $request->discount,
				'transport_cost'   => $request->transport_cost,
				'dsr_cost'         => $request->dsr_cost,
				'grandtotal'       => $request->grandtotal,
				'paid'             => $request->paid,
				'due'              => $request->due,
				'transaction_type' => $request->transaction_type,
				'status'           => "1",
				'admin_id'         => "",
				'created_at'       => now(),

			]);

		}
		else{
			DB::table("dsrsales_ledger")->where('invoice_no',$invoice_no)->update([
				'staff_id'         => Auth('guest')->user()->id,
				'invoice_date'     => $request->invoice_date,
				'invoice_no'       => $invoice_no,
				'shop_id'          => $request->shop_id,
				'shop_number'      => " ",
				'total'            => $request->totalamount,
				'discount'         => $request->discount,
				'transport_cost'   => $request->transport_cost,
				'dsr_cost'         => $request->dsr_cost,
				'grandtotal'       => $request->grandtotal,
				'paid'             => $request->paid,
				'due'              => $request->due,
				'transaction_type' => $request->transaction_type,
				'admin_id'         => "",
				'created_at'       => now(),

			]);

		}




		DB::table("dsrsales_payment")->where('invoice_no',$invoice_no)->update([
			'invoice_no'       => $invoice_no,
			'shop_id'          => $request->shop_id,
			'staff_id'         => Auth('guest')->user()->id,
			'payment_date'     => $request->invoice_date,
			'payment'          => $request->paid,
			'discount'         => $request->discount,
			'opening_balance'  => null,
			'payment_type'     => $request->transaction_type,
			'note'             => "firstpayment",
			'admin_id'         => "",
			'created_at'       => now(),


		]);


		return response()->json($invoice_no);


	}




	public function dsrsalesinvoice($invoice_no){

		$data = DB::table('dsrsales_ledger')
		->where("dsrsales_ledger.invoice_no",$invoice_no)
		->join("staff",'staff.id','dsrsales_ledger.staff_id')
		->join("shops",'shops.id','dsrsales_ledger.shop_id')
		->select("dsrsales_ledger.*",'staff.staff_name','shops.shop_name','shops.shop_number','shops.shop_address')
		->first();

		$product = DB::table("dsrsales_entry")
		->where("dsrsales_entry.invoice_no",$data->invoice_no)
		->join("products",'products.id','dsrsales_entry.product_id')
		->select("dsrsales_entry.*",'products.product_name')
		->get();

		return view("backend.staffdashboard.dsrsales.dsrsalesinvoice",compact('data','product'));
	}





	public function finaldsrsalesinvoice($invoice_no){

		$data = DB::table('dsrsales_ledger')
		->where("dsrsales_ledger.invoice_no",$invoice_no)
		->join("staff",'staff.id','dsrsales_ledger.staff_id')
		->join("shops",'shops.id','dsrsales_ledger.shop_id')
		->select("dsrsales_ledger.*",'staff.staff_name','shops.shop_name','shops.shop_number','shops.shop_address')
		->first();

		$product = DB::table("dsrsales_entry")
		->where("dsrsales_entry.invoice_no",$data->invoice_no)
		->join("products",'products.id','dsrsales_entry.product_id')
		->select("dsrsales_entry.*",'products.product_name')
		->get();

		return view("backend.staffdashboard.dsrsales.finaldsrsalesinvoice",compact('data','product'));
	}


	public function alldsrsalesledger(){

		$data = DB::table('dsrsales_ledger')
		->join("staff",'staff.id','dsrsales_ledger.staff_id')
		->select("dsrsales_ledger.*",'staff.staff_name')
		->orderBy('dsrsales_ledger.id','DESC')
		->where('dsrsales_ledger.status',1)
		->get();


		return view("backend.staffdashboard.dsrsales.alldsrsalesledger",compact('data'));
	}



	public function pendingalldsrsalesledger(){

		$data = DB::table('dsrsales_ledger')
		->join("staff",'staff.id','dsrsales_ledger.staff_id')
		->select("dsrsales_ledger.*",'staff.staff_name')
		->orderBy('dsrsales_ledger.id','DESC')
		->where('dsrsales_ledger.status',null)
		->get();


		return view("backend.staffdashboard.dsrsales.pendingalldsrsalesledger",compact('data'));
	}




	public function dsrstocks(){

		$data['product'] = DB::table("products")
		->get();

		return view("backend.staffdashboard.dsrstock.index",$data);
	}





	public function deletedsrsalescartproduct($id){

		$session_id   = Session::getId();
		$data = DB::table('sales_current')
		->where('session_id',$session_id)
		->where('id',$id)
		->delete();

	}



	public function deletedsrsalesledger($id){

		$data = DB::table('dsrsales_ledger')
		->where("id",$id)
		->first();


		DB::table('dsrsales_ledger')
		->where("id",$id)
		->delete();

		DB::table("dsrsales_entry")
		->where("invoice_no",$data->invoice_no)
		->delete();

		DB::table("dsrsales_payment")
		->where("invoice_no",$data->invoice_no)
		->delete();


		DB::table("dsrstocks")
		->where("invoice_no",$data->invoice_no)
		->delete();



		$notification=array(
			'messege'=>'Invoice Delete Done',
			'alert-type'=>'success'
		);
		return Redirect()->back()->with($notification); 


	}



	


}
