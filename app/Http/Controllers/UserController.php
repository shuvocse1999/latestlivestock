<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Hash;
use DB;

class UserController extends Controller
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
       $data['user'] = User::get();
       return view("backend.user.index",$data);
   }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("backend.user.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $data = new User;
        $data->name         = $request->name;
        $data->email        = $request->email;
        $data->password     = Hash::make($request->password);
        $data->set_password = $request->password;

        $data->save();

        $notification=array(
            'messege'=>'Admin Added Done',
            'alert-type'=>'success'
        );
        return Redirect()->back()->with($notification); 

    }

    /**
     * Display the specified resource.
     */
    public function show(User $User)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $User,$id)
    {
        $User = User::find($id);
        return view("backend.user.edit",compact('User'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $User,$id)
    {



        DB::table("users")->where('id',$id)->update([

            'name'         => $request->name,
            'email'        => $request->email,
            'password'     => Hash::make($request->password),
            'set_password' => $request->password,


        ]);

        $notification=array(
            'messege'=>'Admin Updated Done',
            'alert-type'=>'success'
        );


        return Redirect()->route('admin.index')->with($notification); 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $User,$id)
    {
        $User = User::find($id);
        $User->delete();

        $notification=array(
            'messege'=>'Admin Delete Done',
            'alert-type'=>'success'
        );
        
        return Redirect()->back()->with($notification); 
    }
}
