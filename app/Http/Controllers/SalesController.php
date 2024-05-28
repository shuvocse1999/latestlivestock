<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Staff;
use App\Models\Product;
use DB;
use Session;
use Haruncpi\LaravelIdGenerator\IdGenerator;


class SalesController extends Controller
{

	public function __construct()
	{
		$this->middleware('auth');

	}


	public function create()
	{
		$data['category'] = Category::get();
		$data['brand']    = Brand::get();
		$data['staff']    = Staff::get();
		$data['product']  = Product::get();

		return view("backend.sales.create",$data);

	}


	public function getcatproduct($category_id){


		if ($category_id == 0) {
			$product  =  Product::get();
		}else{
			$product  =  Product::where('category_id',$category_id)->get();
		}

		

		echo "<option value=''>--Select Products--</option>";

		foreach ($product as $p) {
			echo "<option value='$p->id'>$p->product_name</option>";
		}

	}



	public function getbrandproductsales($brand_id){

		
		$session_id   = Session::getId();
		$product = DB::table('products')->where('brand_id',$brand_id)->get();

		

		foreach ($product as $p) {

			$checkaddproduct = DB::table('sales_current')
			->where('session_id',$session_id)
			->where('product_id',$p->id)
			->first();

			if ($checkaddproduct) {
				dd("Product Already Added");
			}
			else{

				DB::table('sales_current')->insert([
					'product_id'         => $p->id,
					'purchase_price'     => $p->purchase_price,
					'sales_price'        => $p->sales_price,
					'session_id'         => $session_id,
					'admin_id'           => Auth()->user()->id,
					'created_at'         => now(),
				]);
			}
			


		}




	}




	public function salescurrentcart(Request $request,$id)
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
				'admin_id'           => Auth()->user()->id,
				'created_at'         => now(),
			]);

		}



	}





	public function showsalescurrentcart(){
		$session_id   = Session::getId();

		$data['product'] = DB::table('sales_current')
		->where('sales_current.session_id',$session_id)
		->join('products','products.id','sales_current.product_id')
		->select('sales_current.*','products.product_name')
		->get();

		return view('backend.sales.showsalescurrentcart',$data);
	}





	public function salescartonupdate(Request $request,$id){

		$session_id   = Session::getId();

		$check = DB::table('sales_current')
		->where('session_id',$session_id)
		->where('id',$id)
		->first();

		$rqty = DB::table("stocks")->where("product_id",$check->product_id)
		->where('status',"purchase")
		->sum("qty");

		$sqty = DB::table("stocks")
		->where("product_id",$check->product_id)
		->where('status',Null)
		->sum("qty");

		$returnqty = DB::table("stocks")
		->where("product_id",$check->product_id)
		->where('status',Null)
		->sum("returnqty");


		$finalsalesqty = $sqty - $returnqty;

		$available = $rqty- $finalsalesqty;


		$data = DB::table('sales_current')
		->where('session_id',$session_id)
		->where('id',$id)
		->update([

			'carton' => $request->carton

		]);

		

	}
	




	public function salespieceupdate(Request $request,$id){

		$session_id   = Session::getId();
		$data = DB::table('sales_current')
		->where('session_id',$session_id)
		->where('id',$id)
		->update([

			'piece' => $request->piece

		]);

	}
	

	public function salesfreeupdate(Request $request,$id){

		$session_id   = Session::getId();
		$data = DB::table('sales_current')
		->where('session_id',$session_id)
		->where('id',$id)
		->update([

			'free' => $request->free

		]);

	}
	


	public function salesreturncartonupdate(Request $request,$id){

		$session_id   = Session::getId();
		$data = DB::table('sales_current')
		->where('session_id',$session_id)
		->where('id',$id)
		->update([

			'returnscarton' => $request->returnscarton

		]);

	}




	public function salesreturnpieceupdate(Request $request,$id){

		$session_id   = Session::getId();
		$data = DB::table('sales_current')
		->where('session_id',$session_id)
		->where('id',$id)
		->update([

			'returnspiece' => $request->returnspiece

		]);

	}








	public function salesdamageupdate(Request $request,$id){

		$session_id   = Session::getId();
		$data = DB::table('sales_current')
		->where('session_id',$session_id)
		->where('id',$id)
		->update([

			'damage' => $request->damage

		]);

	}
	





	public function salespriceupdate(Request $request,$id){

		$session_id   = Session::getId();
		$data = DB::table('sales_current')
		->where('session_id',$session_id)
		->where('id',$id)
		->update([

			'sales_price' => $request->price

		]);

	}


	public function deletesalescartproduct($id){

		$session_id   = Session::getId();
		$data = DB::table('sales_current')
		->where('session_id',$session_id)
		->where('id',$id)
		->delete();

	}





	public function salesledger(Request $request){



		$session_id   = Session::getId();
		$data = DB::table('sales_current')
		->where('session_id',$session_id)
		->get();

		$invoice_no = IdGenerator::generate(['table' => 'sales_ledger', 'field'=>'invoice_no','length' => 10, 'prefix' =>'SI-']);


		foreach ($data as $d) {

			$unit = DB::table("products")->where("id",$d->product_id)->first();

			$checkqty = ($unit->unit_per_group*$d->carton)+$d->piece;

			


				DB::table("sales_entry")->insert([
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
					'admin_id'          => Auth()->user()->id,
					'created_at'        => now(),

				]);


				DB::table("stocks")->insert([
					'invoice_no'         => $invoice_no,
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
					'admin_id'           => Auth()->user()->id,
					'created_at'         => $request->invoice_date,
			        'dsr_id'             => $request->staff_id,

				]);

			
			

		}  


		DB::table("sales_ledger")->insert([
			'staff_id'         => $request->staff_id,
			'invoice_date'     => $request->invoice_date,
			'invoice_no'       => $invoice_no,
			'market'           => $request->market,
			'total'            => $request->totalamount,
			'discount'         => $request->discount,
			'transport_cost'   => $request->transport_cost,
			'dsr_cost'         => $request->dsr_cost,
			'grandtotal'       => $request->grandtotal,
			'paid'             => $request->paid,
			'due'              => $request->due,
			'transaction_type' => $request->transaction_type,
			'admin_id'         => Auth()->user()->id,
			'created_at'       => now(),

		]);


		DB::table("sales_payment")->insert([
			'invoice_no'       => $invoice_no,
			'staff_id'         => $request->staff_id,
			'payment_date'     => $request->invoice_date,
			'payment'          => $request->paid,
			'discount'         => $request->discount,
			'opening_balance'  => null,
			'payment_type'     => $request->transaction_type,
			'note'             => "firstpayment",
			'admin_id'         => Auth()->user()->id,
			'created_at'       => now(),


		]);


		DB::table('sales_current')->where('session_id',$session_id)->delete();
		Session::regenerate();

		$id = DB::table("sales_ledger")->where('invoice_no',$invoice_no)->first();

		return response()->json($id->id);


	}



	public function salesinvoice($invoice_no){

		$data = DB::table('sales_ledger')
		->where("sales_ledger.invoice_no",$invoice_no)
		->join("staff",'staff.id','sales_ledger.staff_id')
		->join("users",'users.id','sales_ledger.admin_id')
		->select("sales_ledger.*",'staff.staff_name','users.name')
		->first();

		$product = DB::table("sales_entry")
		->where("sales_entry.invoice_no",$data->invoice_no)
		->join("products",'products.id','sales_entry.product_id')
	    ->select("sales_entry.*",'products.product_name')
		->get();

		return view("backend.sales.salesinvoice",compact('data','product'));
	}



	public function allsalesledger(){

		$data = DB::table('sales_ledger')
		->join("staff",'staff.id','sales_ledger.staff_id')
		->join("users",'users.id','sales_ledger.admin_id')
		->select("sales_ledger.*",'staff.staff_name','users.name')
		->orderBy('sales_ledger.id','DESC')
		->where('sales_ledger.status',1)
		->get();


		return view("backend.sales.allsalesledger",compact('data'));
	}




	public function pendingallsalesledger(){

		$data = DB::table('sales_ledger')
		->join("staff",'staff.id','sales_ledger.staff_id')
		->join("users",'users.id','sales_ledger.admin_id')
		->select("sales_ledger.*",'staff.staff_name','users.name')
		->orderBy('sales_ledger.id','DESC')
		->where('sales_ledger.status',null)
		->get();


		return view("backend.sales.pendingallsalesledger",compact('data'));
	}


	


	

	public function deletesalesledger($id){

		$data = DB::table('sales_ledger')
		->where("id",$id)
		->first();


		DB::table('sales_ledger')
		->where("id",$id)
		->delete();

		DB::table("sales_entry")
		->where("invoice_no",$data->invoice_no)
		->delete();

		DB::table("sales_payment")
		->where("invoice_no",$data->invoice_no)
		->delete();


		DB::table("stocks")
		->where("invoice_no",$data->invoice_no)
		->delete();



		$notification=array(
			'messege'=>'Invoice Delete Done',
			'alert-type'=>'success'
		);
		return Redirect()->back()->with($notification); 


	}

	public function editsales($id){

		$data['sales'] = DB::table("sales_ledger")->where("id",$id)->first();



			$data['category'] = Category::get();
			$data['brand']    = Brand::get();
			$data['staff']    = Staff::get();
			$data['product']  = Product::get();

			return view("backend.sales.editsales",$data);
		
	}




	public function editsalescurrentcart(Request $request,$id,$invoice_no)
	{

		$session_id   = Session::getId();
		$checkproduct = DB::table('products')->where('id',$id)->first();


		$checkaddproduct = DB::table('sales_entry')
		->where('invoice_no',$invoice_no)
		->where('product_id',$id)
		->first();

		if ($checkaddproduct) 
		{

			dd("Product Already Added");


		}
		else
		{

			DB::table('sales_entry')->insert([
				'invoice_no'         => $invoice_no,
				'product_id'         => $id,
				'purchase_price'     => $checkproduct->purchase_price,
				'sales_price'        => $checkproduct->sales_price,
				'session_id'         => "",
				'admin_id'           => Auth()->user()->id,
				'created_at'         => now(),
			]);

			DB::table('stocks')->insert([
				'invoice_no'         => $invoice_no,
				'product_id'         => $id,
				'purchase_price'     => $checkproduct->purchase_price,
				'sales_price'        => $checkproduct->sales_price,
				'admin_id'           => Auth()->user()->id,
				'created_at'         => now(),
			]);

		}



	}




	public function showeditsalescurrentcart($invoice_no){


		$data['product'] = DB::table('sales_entry')
		->where('sales_entry.invoice_no',$invoice_no)
		->join('products','products.id','sales_entry.product_id')
		->select('sales_entry.*','products.product_name')
		->get();


		return view('backend.sales.showeditsalescurrentcart',$data);
	}

	






	public function editsalescartonupdate(Request $request,$id,$invoice_no){


		$session_id   = Session::getId();

		$check = DB::table('sales_entry')
		->where('id',$id)
		->where("invoice_no",$invoice_no)
		->first();

		$product = DB::table("products")
		->where('id',$check->product_id)
		->first();


		$checkqty = DB::table('stocks')
		->where('product_id',$check->product_id)
		->where("invoice_no",$invoice_no)
		->first();


		$data = DB::table('sales_entry')
		->where('id',$id)
		->where("invoice_no",$invoice_no)
		->update([

			'carton' => $request->carton,
			'qty'   => $request->carton*$product->unit_per_group+$check->piece

		]);

		

		$stock = DB::table('stocks')
		->where('product_id',$check->product_id)
		->where("invoice_no",$invoice_no)
		->update([

			'carton' => $request->carton,
			'qty'   => $request->carton*$product->unit_per_group+$check->piece

		]);


	}
	

	public function editsalespieceupdate(Request $request,$id,$invoice_no){

		$session_id   = Session::getId();

		$check = DB::table('sales_entry')
		->where('id',$id)
		->where("invoice_no",$invoice_no)
		->first();

		$product = DB::table("products")
		->where('id',$check->product_id)
		->first();


		$checkqty = DB::table('stocks')
		->where('product_id',$check->product_id)
		->where("invoice_no",$invoice_no)
		->first();


		$data = DB::table('sales_entry')
		->where('id',$id)
		->where("invoice_no",$invoice_no)
		->update([

			'piece' => $request->piece,
			'qty'   => $request->piece+($check->carton*$product->unit_per_group)

		]);

		

		$stock = DB::table('stocks')
		->where('product_id',$check->product_id)
		->where("invoice_no",$invoice_no)
		->update([

			'piece' => $request->piece,
			'qty'   => $request->piece+($check->carton*$product->unit_per_group)

		]);


	}
	




	public function editsalesfreeupdate(Request $request,$id,$invoice_no){

		$session_id   = Session::getId();
		$data = DB::table('sales_entry')
		->where("invoice_no",$invoice_no)
		->where('id',$id)
		->update([

			'free' => $request->free

		]);


		$check = DB::table('sales_entry')
		->where('id',$id)
		->where("invoice_no",$invoice_no)
		->first();


		$stock = DB::table('stocks')
		->where('product_id',$check->product_id)
		->where("invoice_no",$invoice_no)
		->update([

			'free' => $request->free

		]);

	}
	


	public function editsalesreturncartonupdate(Request $request,$id,$invoice_no){

		$session_id   = Session::getId();
		$data = DB::table('sales_entry')
		->where("invoice_no",$invoice_no)
		->where('id',$id)
		->update([

			'returnscarton' => $request->returnscarton

		]);



		$check = DB::table('sales_entry')
		->where('id',$id)
		->where("invoice_no",$invoice_no)
		->first();

		$product = DB::table("products")
		->where("id",$check->product_id)
		->first();

		$stock = DB::table('stocks')
		->where('product_id',$check->product_id)
		->where("invoice_no",$invoice_no)
		->update([

			'returncarton' => $request->returnscarton,
			'returnqty'    => ($request->returnscarton*$product->unit_per_group)+$check->returnspiece,

		]);

	}




	public function editsalesreturnpieceupdate(Request $request,$id,$invoice_no){

		$session_id   = Session::getId();
		$data = DB::table('sales_entry')
		->where("invoice_no",$invoice_no)
		->where('id',$id)
		->update([

			'returnspiece' => $request->returnspiece

		]);


		$check = DB::table('sales_entry')
		->where('id',$id)
		->where("invoice_no",$invoice_no)
		->first();

		$product = DB::table("products")
		->where("id",$check->product_id)
		->first();


		$stock = DB::table('stocks')
		->where('product_id',$check->product_id)
		->where("invoice_no",$invoice_no)
		->update([

			'returnpiece' => $request->returnspiece,
			'returnqty'    => ($check->returnscarton*$product->unit_per_group)+$request->returnspiece,

		]);

	}








	public function editsalesdamageupdate(Request $request,$id,$invoice_no){

		$session_id   = Session::getId();
		$data = DB::table('sales_entry')
		->where("invoice_no",$invoice_no)
		->where('id',$id)
		->update([

			'damage' => $request->damage

		]);



		$check = DB::table('sales_entry')
		->where('id',$id)
		->where("invoice_no",$invoice_no)
		->first();



		$stock = DB::table('stocks')
		->where('product_id',$check->product_id)
		->where("invoice_no",$invoice_no)
		->update([

			'damage' => $request->damage

		]);





	}
	





	public function editsalespriceupdate(Request $request,$id,$invoice_no){

		$session_id   = Session::getId();
		$data = DB::table('sales_entry')
		->where("invoice_no",$invoice_no)
		->where('id',$id)
		->update([

			'sales_price' => $request->price

		]);

	}


	public function deleteeditsalescartproduct($id,$invoice_no){

		$session_id   = Session::getId();
		$data = DB::table('sales_entry')
		->where("invoice_no",$invoice_no)
		->where('product_id',$id)
		->delete();

		$data = DB::table('stocks')
		->where("invoice_no",$invoice_no)
		->where('product_id',$id)
		->delete();

	}





	public function editsalesledger(Request $request,$invoice_no){


		if ($request->status == 1) {
			DB::table("sales_ledger")->where('invoice_no',$invoice_no)->update([
				'staff_id'         => $request->staff_id,
				'invoice_date'     => $request->invoice_date,
				'invoice_no'       => $invoice_no,
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
				'admin_id'         => Auth()->user()->id,
				'created_at'       => now(),

			]);

		}
		else{
			DB::table("sales_ledger")->where('invoice_no',$invoice_no)->update([
				'staff_id'         => $request->staff_id,
				'invoice_date'     => $request->invoice_date,
				'invoice_no'       => $invoice_no,
				'market'           => $request->market,
				'total'            => $request->totalamount,
				'discount'         => $request->discount,
				'transport_cost'   => $request->transport_cost,
				'dsr_cost'         => $request->dsr_cost,
				'grandtotal'       => $request->grandtotal,
				'paid'             => $request->paid,
				'due'              => $request->due,
				'transaction_type' => $request->transaction_type,
				'admin_id'         => Auth()->user()->id,
				'created_at'       => now(),

			]);

		}




		DB::table("sales_payment")->where('invoice_no',$invoice_no)->update([
			'invoice_no'       => $invoice_no,
			'staff_id'         => $request->staff_id,
			'payment_date'     => $request->invoice_date,
			'payment'          => $request->paid,
			'discount'         => $request->discount,
			'opening_balance'  => null,
			'payment_type'     => $request->transaction_type,
			'note'             => "firstpayment",
			'admin_id'         => Auth()->user()->id,
			'created_at'       => now(),


		]);


		return response()->json($invoice_no);


	}



	public function finalsalesinvoice($invoice_no){

		$data = DB::table('sales_ledger')
		->where("sales_ledger.invoice_no",$invoice_no)
		->join("staff",'staff.id','sales_ledger.staff_id')
		->join("users",'users.id','sales_ledger.admin_id')
		->select("sales_ledger.*",'staff.staff_name','users.name')
		->first();

		$product = DB::table("sales_entry")
		->where("sales_entry.invoice_no",$data->invoice_no)
		->join("products",'products.id','sales_entry.product_id')
		->select("sales_entry.*",'products.product_name')
		->get();

		return view("backend.sales.finalsalesinvoice",compact('data','product'));
	}




}
