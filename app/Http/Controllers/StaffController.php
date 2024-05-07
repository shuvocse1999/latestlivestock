<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use Illuminate\Http\Request;
use Hash;

class StaffController extends Controller
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
       $data['staff'] = Staff::where('designation','dsr')->orderBy('id','DESC')->get();
       return view("backend.staff.index",$data);
   }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("backend.staff.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $data = $request->all();
        $data['set_password'] = $data['password'];
        $data['password'] = Hash::make($data['password']);


        Staff::create($data);

        $notification=array(
            'messege'=>'Staff Added Done',
            'alert-type'=>'success'
        );
        return Redirect()->back()->with($notification); 

    }

    /**
     * Display the specified resource.
     */
    public function show(Staff $staff)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Staff $staff)
    {
        return view("backend.staff.edit",compact('staff'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Staff $staff)
    {

        $data = $request->all();

        if(isset($data['password'])) {
            $data['set_password'] = $data['password'];
            $data['password'] = Hash::make($data['password']);
        }

        $staff->update($data);

        $notification=array(
            'messege'=>'Staff Update Done',
            'alert-type'=>'success'
        );

        return Redirect()->route('staff.index')->with($notification); 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Staff $staff,$id)
    {
        $staff = Staff::find($id);
        $staff->delete();

        $notification=array(
            'messege'=>'Staff Delete Done',
            'alert-type'=>'success'
        );
        
        return Redirect()->back()->with($notification); 
    }
}
