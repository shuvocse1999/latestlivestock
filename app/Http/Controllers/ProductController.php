<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Http\Request;
use DB;

class ProductController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');

    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['product'] = Product::join('categories','categories.id','products.category_id')
        ->join('brands','brands.id','products.brand_id')
        ->select("products.*",'categories.category_name','brands.brand_name')
        ->get();

        return view("backend.product.index",$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['category'] = Category::get();
        $data['brand'] = Brand::get();

        return view("backend.product.create",$data);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $data = $request->all();


        Product::create($data);

        $notification=array(
            'messege'=>'Product Added Done',
            'alert-type'=>'success'
        );
        return Redirect()->back()->with($notification); 

    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {

        $category = Category::get();
        $brand    = Brand::get();
        return view("backend.product.edit",compact('product','category','brand'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $product->update($request->all());
        $notification=array(
            'messege'=>'Product Update Done',
            'alert-type'=>'success'
        );
        
        return Redirect()->route('product.index')->with($notification); 


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product,$id)
    {



        DB::table("products")->where("id",$id)->delete();

        $notification=array(
            'messege'=>'Product Delete Done',
            'alert-type'=>'success'
        );
        
        return Redirect()->back()->with($notification); 
    }
}
