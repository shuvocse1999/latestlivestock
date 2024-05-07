<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Supplier;
use App\Models\Product;
use DB;
use Session;
use Haruncpi\LaravelIdGenerator\IdGenerator;


class PurchaseController extends Controller
{

	public function __construct()
	{
		$this->middleware('auth');

	}


	public function create()
	{
		$data['category'] = Category::get();
		$data['brand']    = Brand::get();
		$data['supplier'] = Supplier::get();
		$data['product']  = Product::get();

		return view("backend.purchase.create",$data);

	}


	public function getprevdue($supplier_id){

		$ledger  = DB::table("purchase_ledger")->where("supplier_id",$supplier_id)->sum('grandtotal');
		$payment = DB::table("purchase_payment")->where("supplier_id",$supplier_id)->sum('payment');

		$due = $ledger - $payment;

		return response()->json(number_format($due,2));

	}



	


	public function getcatproduct($category_id){

		$product  =  Product::where('category_id',$category_id)->get();

		echo "<option value=''>--Select Products--</option>";

		foreach ($product as $p) {
			echo "<option value='$p->id'>$p->product_name</option>";
		}

	}



	public function getbrandproduct($brand_id){

		
		$session_id   = Session::getId();
		$product = DB::table('products')->where('brand_id',$brand_id)->get();

		

		foreach ($product as $p) {

			$checkaddproduct = DB::table('purchase_current')
			->where('session_id',$session_id)
			->where('product_id',$p->id)
			->first();

			if ($checkaddproduct) {
				dd("Product Already Added");
			}
			else{

				DB::table('purchase_current')->insert([
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




	public function purchasecurrentcart(Request $request,$id)
	{

		$session_id   = Session::getId();
		$checkproduct = DB::table('products')->where('id',$id)->first();


		$checkaddproduct = DB::table('purchase_current')
		->where('session_id',$session_id)
		->where('product_id',$id)
		->first();

		if ($checkaddproduct) 
		{

			dd("Product Already Added");


		}
		else
		{

			DB::table('purchase_current')->insert([
				'product_id'         => $id,
				'purchase_price'     => $checkproduct->purchase_price,
				'sales_price'        => $checkproduct->sales_price,
				'session_id'         => $session_id,
				'admin_id'           => Auth()->user()->id,
				'created_at'         => now(),
			]);

		}



	}





	public function showpurchasecurrentcart(){
		$session_id   = Session::getId();

		$data['product'] = DB::table('purchase_current')
		->where('purchase_current.session_id',$session_id)
		->join('products','products.id','purchase_current.product_id')
		->select('purchase_current.*','products.product_name')
		->get();

		return view('backend.purchase.showpurchasecurrentcart',$data);
	}





	public function purchasecartonupdate(Request $request,$id){

		$session_id   = Session::getId();
		$data = DB::table('purchase_current')
		->where('session_id',$session_id)
		->where('id',$id)
		->update([

			'carton' => $request->carton

		]);

	}
	




	public function purchasepieceupdate(Request $request,$id){

		$session_id   = Session::getId();
		$data = DB::table('purchase_current')
		->where('session_id',$session_id)
		->where('id',$id)
		->update([

			'piece' => $request->piece

		]);

	}
	

	public function purchasefreeupdate(Request $request,$id){

		$session_id   = Session::getId();
		$data = DB::table('purchase_current')
		->where('session_id',$session_id)
		->where('id',$id)
		->update([

			'free' => $request->free

		]);

	}
	



	public function purchasepriceupdate(Request $request,$id){

		$session_id   = Session::getId();
		$data = DB::table('purchase_current')
		->where('session_id',$session_id)
		->where('id',$id)
		->update([

			'purchase_price' => $request->price

		]);

	}


	public function deletepurchasecartproduct($id){

		$session_id   = Session::getId();
		$data = DB::table('purchase_current')
		->where('session_id',$session_id)
		->where('id',$id)
		->delete();

	}





	public function purchaseledger(Request $request){



		$session_id   = Session::getId();
		$data = DB::table('purchase_current')
		->where('session_id',$session_id)
		->get();

		$invoice_no = IdGenerator::generate(['table' => 'purchase_ledger', 'field'=>'invoice_no','length' => 10, 'prefix' =>'PI-']);


		foreach ($data as $d) {

			$unit = DB::table("products")->where("id",$d->product_id)->first();

			$checkqty = ($unit->unit_per_group*$d->carton)+$d->piece;

			if ($checkqty > 0) {
				
				DB::table("purchase_entry")->insert([
					'invoice_no'        => $invoice_no,
					'product_id'        => $d->product_id,
					'carton'            => $d->carton,
					'piece'             => $d->piece,
					'qty'               => ($unit->unit_per_group*$d->carton)+$d->piece,
					'free'              => $d->free,
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
					'purchase_return'    => null,
					'sales_return'       => null,
					'damage'             => null,
					'purchase_price'     => $d->purchase_price,
					'sales_price'        => $d->sales_price,
					'status'             => "purchase",
					'admin_id'           => Auth()->user()->id,
					'created_at'         => $request->invoice_date,
				]);

			}
			

		}  


		DB::table("purchase_ledger")->insert([
			'supplier_id'      => $request->supplier_id,
			'invoice_date'     => $request->invoice_date,
			'invoice_no'       => $invoice_no,
			'voucer'           => $request->voucer,
			'total'            => $request->totalamount,
			'discount'         => $request->discount,
			'transport_cost'   => $request->transport_cost,
			'grandtotal'       => $request->grandtotal,
			'paid'             => $request->paid,
			'due'              => $request->due,
			'transaction_type' => $request->transaction_type,
			'admin_id'         => Auth()->user()->id,
			'created_at'       => now(),

		]);


		DB::table("purchase_payment")->insert([
			'invoice_no'       => $invoice_no,
			'supplier_id'      => $request->supplier_id,
			'payment_date'     => $request->invoice_date,
			'payment'          => $request->paid,
			'discount'         => $request->discount,
			'opening_balance'  => null,
			'payment_type'     => $request->transaction_type,
			'note'             => "firstpayment",
			'admin_id'         => Auth()->user()->id,
			'created_at'       => now(),


		]);


		DB::table('purchase_current')->where('session_id',$session_id)->delete();
		Session::regenerate();

		return response()->json($invoice_no);


	}



	public function purchaseinvoice($invoice_no){

		$data = DB::table('purchase_ledger')
		->where("purchase_ledger.invoice_no",$invoice_no)
		->join("suppliers",'suppliers.id','purchase_ledger.supplier_id')
		->join("users",'users.id','purchase_ledger.admin_id')
		->select("purchase_ledger.*",'suppliers.supplier_name','users.name')
		->first();

		$product = DB::table("purchase_entry")
		->where("purchase_entry.invoice_no",$data->invoice_no)
		->join("products",'products.id','purchase_entry.product_id')
		->select("purchase_entry.*",'products.product_name')
		->get();

		return view("backend.purchase.purchaseinvoice",compact('data','product'));
	}



	public function allpurchaseledger(){

		$data = DB::table('purchase_ledger')
		->join("suppliers",'suppliers.id','purchase_ledger.supplier_id')
		->join("users",'users.id','purchase_ledger.admin_id')
		->select("purchase_ledger.*",'suppliers.supplier_name','users.name')
		->orderBy('purchase_ledger.id','DESC')
		->get();


		return view("backend.purchase.allpurchaseledger",compact('data'));
	}


	

	public function deletepurchaseledger($id){

		$data = DB::table('purchase_ledger')
		->where("id",$id)
		->first();


		DB::table('purchase_ledger')
		->where("id",$id)
		->delete();

		DB::table("purchase_entry")
		->where("invoice_no",$data->invoice_no)
		->delete();

		DB::table("purchase_payment")
		->where("invoice_no",$data->invoice_no)
		->delete();


		DB::table("stocks")
		->where("invoice_no",$data->invoice_no)
		->delete();



		$notification=array(
			'messege'=>'Voucher Delete Done',
			'alert-type'=>'success'
		);
		return Redirect()->back()->with($notification); 


	}

	


}
