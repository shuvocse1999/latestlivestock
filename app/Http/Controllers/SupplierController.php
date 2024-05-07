<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
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
       $data['supplier'] = Supplier::get();
       return view("backend.supplier.index",$data);
   }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("backend.supplier.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $data = $request->all();


        Supplier::create($data);

        $notification=array(
            'messege'=>'Supplier Added Done',
            'alert-type'=>'success'
        );
        return Redirect()->back()->with($notification); 

    }

    /**
     * Display the specified resource.
     */
    public function show(Supplier $supplier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Supplier $supplier)
    {
        return view("backend.supplier.edit",compact('supplier'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Supplier $supplier)
    {
        $supplier->update($request->all());

      $notification=array(
        'messege'=>'Supplier Update Done',
        'alert-type'=>'success'
    );

     return Redirect()->route('supplier.index')->with($notification); 
 }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier,$id)
    {
        $supplier = Supplier::find($id);
        $supplier->delete();

        $notification=array(
            'messege'=>'Supplier Delete Done',
            'alert-type'=>'success'
        );
        
        return Redirect()->back()->with($notification); 
    }
}
