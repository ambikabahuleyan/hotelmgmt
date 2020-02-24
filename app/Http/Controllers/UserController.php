<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\room;
use App\booking;
use Illuminate\Support\Facades\Validator;
class UserController extends Controller
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
   
  public function index()
  {
    $data['rooms']=room::orderBy('id')->get();
    return view('index',$data);
  }

  public function room_detail($id)
  { 
    $data=[];
     return view('room_details',$data);

  }
  public function check_availability(Request $request)
  {
        $validator = Validator::make($request->all(), [
            'arraival' => 'required',
            'checkout' => 'required',           
        ]);
         if ($validator->fails()) { 

          $op['msg']='must fill arrival and checkout';
          $op['statusCode']=422;
           return ($op);
        }   
        else
        { 
  
          $postdata=$request->all(); 
          $data=room::with('booking')->get();
           foreach ($data as $k => $value) {
             $flag=0;
             if(!empty($value['booking']))
            {
              foreach ($value['booking'] as $bk => $b) {            
              if(($postdata['arraival'] >=  $b['arrival'] && $postdata['arraival']  <=$b['checkout']) || ($postdata['checkout'] >=  $b['arrival'] && $postdata['checkout']  <=$b['checkout']))
               {
                 $flag=1;
               }
          
               }                    
            }

          if($flag)
           {
                 unset($data[$k]);
           }
         }
        if(!empty($data->toArray()))  
        {
          $op['room']=$data;
          $op['status']='success';
          $op['statusCode']=200;

        }
        else{
          $op['msg']='Sorry! No  rooms avialable on these date';
          $op['status']='success';
          $op['statusCode']=422;

        }
       
       return ($op);
    }  
  }

  public function book_room(Request $request)
  {
   
     $validator = Validator::make($request->all(), [
            'arraival' => 'required',
            'checkout' => 'required',
        ]);
     if ($validator->fails()) {

          $op['msg']='must fill arraival and checkout';
          $op['statusCode']=422;
           return ($op);
        }   
        else
        { 
             $postdata=$request->all();
             $data['arrival']=$postdata['arraival'];
             $data['checkout']=$postdata['checkout'];
             $data['room_id']=$postdata['room_id'];
             $data['status']=1;
             $data['user_id']=200;
             $res= booking::create($data);
          if(!empty($res->toArray()))
          {
              $op['status']='success';
              $op['statusCode']=200;
              $op['msg']='bookking successful';
          }
          else
          {
          $op['msg']='sorry Something went wrong';
          $op['statusCode']=422;
          }
          return ($op);
        }

  }

   
   
    

}