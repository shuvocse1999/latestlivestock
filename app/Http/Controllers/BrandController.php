<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
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
        $data['brand'] = Brand::get();
       return view("backend.brand.index",$data);
   }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $data = $request->all();


        Brand::create($data);

        $notification=array(
            'messege'=>'Brand Added Done',
            'alert-type'=>'success'
        );
        return Redirect()->back()->with($notification); 

    }

    /**
     * Display the specified resource.
     */
    public function show(Brand $brand)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Brand $brand)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Brand $brand)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brand,$id)
    {
        $Brand = Brand::find($id);
        $Brand->delete();

        $notification=array(
            'messege'=>'Brand Delete Done',
            'alert-type'=>'success'
        );
        
        return Redirect()->back()->with($notification); 
    }
}
