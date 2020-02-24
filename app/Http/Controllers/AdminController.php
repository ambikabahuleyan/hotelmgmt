<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\room;
use App\booking;
use Illuminate\Support\Facades\Validator;
class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
      
         $this->room = new room();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
     public function add_rooms(Request $request)
    {  

        if ($request->isMethod('post'))
        {
            
        $validator = Validator::make($request->all(), [
            'room_no' => 'required|unique:rooms|integer',
            'price' => 'required|integer',
            'max_person' => 'required|integer',
            'description' => 'required',
            'Image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',


        ]);
         if ($validator->fails()) {
            return back()->withErrors($validator)
                        ->withInput();
        }   
        else
        { 

        $imageName = time().'.'.request()->Image->getClientOriginalExtension();

        request()->Image->move(public_path('images'), $imageName);
            $postdata=[
            'room_no' => $request->room_no,
            'price' => $request->price,
            'max_person' => $request->max_person,
            'description' => $request->description,
            'image' => $imageName,
            'locked' =>1,


        ];
 
            $res= room::create($postdata);
         if(!empty($res->toArray()))  
        {
          echo"successfully added";

        }
        else{
          echo"Something went wrong";
 
        }
     
         

        }                   
    }
     else{

             return view('admin/add_rooms');
          }
    }

    public function dashbord()
    {
     
      $res['booking']= booking::with('booking')->get()->toArray();
    
       return view('admin/dashbord',$res);
      
    }


    

}