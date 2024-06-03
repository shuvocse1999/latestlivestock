<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\StaffpaymentController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\IncomeexpenseController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DatabaseController;
use App\Http\Controllers\DamageController;
use App\Http\Controllers\StaffLoginController;
use App\Http\Controllers\StaffDashboardController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\ShoppaymentController;



// Admin

Route::get('/', function () {
	return redirect('login');
});

Route::get('stafflogin', [StaffLoginController::class, 'stafflogin']);
Route::post('staffloginnow', [StaffLoginController::class, 'staffloginnow']);
Route::get('staffdashboard', [StaffDashboardController::class, 'staffdashboard']);
Route::get('stafflogout', [StaffDashboardController::class, 'stafflogout']);



// Dsr Sales

Route::get('dsrproductrecivedlist', [StaffDashboardController::class, 'dsrproductrecivedlist']);
Route::get('dsrsales', [StaffDashboardController::class, 'create']);
Route::get("dsrpurchaseinvoice/{invoice_no}",[StaffDashboardController::class,'dsrpurchaseinvoice']);

Route::get("showdsrsalescurrentcart",[StaffDashboardController::class,'showdsrsalescurrentcart']);
Route::get("salesdsrcurrentcart/{id}",[StaffDashboardController::class,'salesdsrcurrentcart']);
Route::get("deletedsrsalescartproduct/{id}",[StaffDashboardController::class,'deletedsrsalescartproduct']);
Route::get("dsrsalescartonupdate/{id}",[StaffDashboardController::class,'dsrsalescartonupdate']);
Route::get("dsrsalespieceupdate/{id}",[StaffDashboardController::class,'dsrsalespieceupdate']);
Route::get("dsrsalespriceupdate/{id}",[StaffDashboardController::class,'dsrsalespriceupdate']);
Route::post("dsrsalesledger",[StaffDashboardController::class,'dsrsalesledger']);

Route::get("deletedsrsalesledger/{id}",[StaffDashboardController::class,'deletedsrsalesledger']);


Route::get("editdsrsales/{id}",[StaffDashboardController::class,'dsreditsales']);
Route::get("showeditdsrsalescurrentcart/{invoice_no}",[StaffDashboardController::class,'showeditdsrsalescurrentcart']);
Route::post("editdsrsalesledger/{invoice_no}",[StaffDashboardController::class,'editdsrsalesledger']);

Route::get("finaldsrsalesinvoice/{invoice_no}",[StaffDashboardController::class,'finaldsrsalesinvoice']);
Route::get("dsrsalesinvoice/{invoice_no}",[StaffDashboardController::class,'dsrsalesinvoice']);

Route::get("alldsrsalesledger",[StaffDashboardController::class,'alldsrsalesledger']);
Route::get("pendingalldsrsalesledger",[StaffDashboardController::class,'pendingalldsrsalesledger']);


// Stocks

Route::get("dsrstocks",[StaffDashboardController::class,'dsrstocks']);



// Shop


Route::resource('shop', ShopController::class);
Route::get('deleteshop/{id}', [ShopController::class, 'destroy']);


// Shop Payment

Route::get("shoppayment",[ShoppaymentController::class,'create']);
Route::get("getshopdue/{shop_id}",[ShoppaymentController::class,'getshopdue']);
Route::post("shoppaymententry",[ShoppaymentController::class,'shoppaymententry']);
Route::get("allshoppayment",[ShoppaymentController::class,'index']);
Route::get("deleteshoppayment/{id}",[ShoppaymentController::class,'deleteshoppayment']);



Route::get('/dashboard', function () {
	return view('backend.layouts.home');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
	Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
	Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
	Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


// Admin

Route::resource('admin', UserController::class);
Route::get('deleteadmin/{id}', [UserController::class, 'destroy']);


// Category

Route::resource('category', CategoryController::class);
Route::get('deletecategory/{id}', [CategoryController::class, 'destroy']);


// Brand

Route::resource('brand', BrandController::class);
Route::get('deletebrand/{id}', [BrandController::class, 'destroy']);

// Product

Route::resource('product', ProductController::class);
Route::get('deleteproduct/{id}', [ProductController::class, 'destroy']);

// Supplier

Route::resource('supplier', SupplierController::class);
Route::get('deletesupplier/{id}', [SupplierController::class, 'destroy']);

// Purchase

Route::get("purchase",[PurchaseController::class,'create']);
Route::get("getprevdue/{supplier_id}",[PurchaseController::class,'getprevdue']);
Route::get("getcatproduct/{category_id}",[PurchaseController::class,'getcatproduct']);
Route::get("getbrandproduct/{brand_id}",[PurchaseController::class,'getbrandproduct']);

Route::get("purchasecurrentcart/{id}",[PurchaseController::class,'purchasecurrentcart']);
Route::get("showpurchasecurrentcart",[PurchaseController::class,'showpurchasecurrentcart']);
Route::get("purchasecartonupdate/{id}",[PurchaseController::class,'purchasecartonupdate']);
Route::get("purchasepieceupdate/{id}",[PurchaseController::class,'purchasepieceupdate']);
Route::get("purchasefreeupdate/{id}",[PurchaseController::class,'purchasefreeupdate']);
Route::get("purchasepriceupdate/{id}",[PurchaseController::class,'purchasepriceupdate']);
Route::get("deletepurchasecartproduct/{id}",[PurchaseController::class,'deletepurchasecartproduct']);
Route::post("purchaseledger",[PurchaseController::class,'purchaseledger']);
Route::get("purchaseinvoice/{invoice_no}",[PurchaseController::class,'purchaseinvoice']);
Route::get("allpurchaseledger",[PurchaseController::class,'allpurchaseledger']);
Route::get("deletepurchaseledger/{id}",[PurchaseController::class,'deletepurchaseledger']);

// Sales

Route::get("sales",[SalesController::class,'create']);
Route::get("getcatproduct/{category_id}",[SalesController::class,'getcatproduct']);
Route::get("getbrandproductsales/{brand_id}",[SalesController::class,'getbrandproductsales']);


Route::get("salescurrentcart/{id}",[SalesController::class,'salescurrentcart']);
Route::get("showsalescurrentcart",[SalesController::class,'showsalescurrentcart']);
Route::get("salescartonupdate/{id}",[SalesController::class,'salescartonupdate']);
Route::get("salespieceupdate/{id}",[SalesController::class,'salespieceupdate']);
Route::get("salesfreeupdate/{id}",[SalesController::class,'salesfreeupdate']);
Route::get("salespriceupdate/{id}",[SalesController::class,'salespriceupdate']);
Route::get("deletesalescartproduct/{id}",[SalesController::class,'deletesalescartproduct']);
Route::post("salesledger",[SalesController::class,'salesledger']);
Route::get("salesinvoice/{invoice_no}",[SalesController::class,'salesinvoice']);
Route::get("allsalesledger",[SalesController::class,'allsalesledger']);
Route::get("deletesalesledger/{id}",[SalesController::class,'deletesalesledger']);
Route::get("salesdamageupdate/{id}",[SalesController::class,'salesdamageupdate']);
Route::get("salesreturncartonupdate/{id}",[SalesController::class,'salesreturncartonupdate']);
Route::get("salesreturnpieceupdate/{id}",[SalesController::class,'salesreturnpieceupdate']);



Route::get("editsalescurrentcart/{id}/{invoice_no}",[SalesController::class,'editsalescurrentcart']);
Route::get("editsales/{id}",[SalesController::class,'editsales']);
Route::get("showeditsalescurrentcart/{invoice_no}",[SalesController::class,'showeditsalescurrentcart']);
Route::get("editsalescartonupdate/{id}/{invoice_no}",[SalesController::class,'editsalescartonupdate']);
Route::get("editsalespieceupdate/{id}/{invoice_no}",[SalesController::class,'editsalespieceupdate']);
Route::get("editsalesfreeupdate/{id}/{invoice_no}",[SalesController::class,'editsalesfreeupdate']);
Route::get("editsalespriceupdate/{id}/{invoice_no}",[SalesController::class,'editsalespriceupdate']);
Route::get("deleteeditsalescartproduct/{id}/{invoice_no}",[SalesController::class,'deleteeditsalescartproduct']);
Route::get("editsalesreturncartonupdate/{id}/{invoice_no}",[SalesController::class,'editsalesreturncartonupdate']);
Route::get("editsalesreturnpieceupdate/{id}/{invoice_no}",[SalesController::class,'editsalesreturnpieceupdate']);
Route::get("editsalesdamageupdate/{id}/{invoice_no}",[SalesController::class,'editsalesdamageupdate']);
Route::post("editsalesledger/{invoice_no}",[SalesController::class,'editsalesledger']);
Route::get("finalsalesinvoice/{invoice_no}",[SalesController::class,'finalsalesinvoice']);
Route::get("pendingallsalesledger",[SalesController::class,'pendingallsalesledger']);

// Stocks

Route::get("stocks",[StockController::class,'index']);

// Staff


Route::resource('staff', StaffController::class);
Route::get('deletestaff/{id}', [StaffController::class, 'destroy']);


// Staff Payment

Route::get("staffpayment",[StaffpaymentController::class,'create']);
Route::get("getstaffdue/{staff_id}",[StaffpaymentController::class,'getstaffdue']);
Route::post("paymententry",[StaffpaymentController::class,'paymententry']);
Route::get("allstaffpayment",[StaffpaymentController::class,'index']);
Route::get("deletestaffpayment/{id}",[StaffpaymentController::class,'deletestaffpayment']);


// Damage 

Route::get("damage",[DamageController::class,'create']);
Route::post("damageinsert",[DamageController::class,'insert']);
Route::get("damagereports",[DamageController::class,'damagereports']);
Route::get("searchdamagereports",[DamageController::class,'searchdamagereports']);



// Income Expense
Route::get("incomeexpense",[IncomeexpenseController::class,'create']);
Route::get("allincomeexpense",[IncomeexpenseController::class,'index']);
Route::post("insertincomeexpense",[IncomeexpenseController::class,'store']);
Route::get("deleteincomeexpense/{id}",[IncomeexpenseController::class,'delete']);



// Reports

Route::get("stockreports",[ReportsController::class,'stockreports']);
Route::get("searchstockreports",[ReportsController::class,'searchstockreports']);

Route::get("dsrreports",[ReportsController::class,'dsrreports']);
Route::get("searchdsrreports",[ReportsController::class,'searchdsrreports']);


Route::get("profitreports",[ReportsController::class,'profitreports']);
Route::get("searchprofitreports",[ReportsController::class,'searchprofitreports']);

Route::get('/downloaddatabase', [DatabaseController::class,'download']);

Route::get("dsrstockreportsbyadmin",[ReportsController::class,'dsrstockreportsbyadmin']);
Route::get("searchdsrstockreportsbyadmin",[ReportsController::class,'searchdsrstockreportsbyadmin']);

