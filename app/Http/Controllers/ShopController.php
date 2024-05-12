<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use Illuminate\Http\Request;
use Hash;

class ShopController extends Controller
{

    public function __construct()
	{
		$this->middleware('guestauth');

	}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $data['shop'] = Shop::orderBy('id','DESC')->get();
       return view("backend.staffdashboard.shop.index",$data);
   }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("backend.staffdashboard.shop.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $data = $request->all();
     
        Shop::create($data);

        $notification=array(
            'messege'=>'Shop Added Done',
            'alert-type'=>'success'
        );
        return Redirect()->back()->with($notification); 

    }

    /**
     * Display the specified resource.
     */
    public function show(Shop $shop)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Shop $shop)
    {
        return view("backend.staffdashboard.shop.edit",compact('shop'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Shop $shop)
    {

        $data = $request->all();

        $shop->update($data);

        $notification=array(
            'messege'=>'Shop Update Done',
            'alert-type'=>'success'
        );

        return Redirect()->route('shop.index')->with($notification); 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Shop $shop,$id)
    {
        $shop = Shop::find($id);
        $shop->delete();

        $notification=array(
            'messege'=>'Shop Delete Done',
            'alert-type'=>'success'
        );
        
        return Redirect()->back()->with($notification); 
    }
}
