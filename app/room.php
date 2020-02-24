<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class room extends Model
{
  
protected $fillable= ['room_no','price','max_person','image','description','locked',];
 public function booking()
    {
      return $this->hasMany('App\booking')->whereIn('status',[1,2]);
    }



   
        
}
