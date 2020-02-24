<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class booking extends Model
{
	protected $fillable= ['user_id','room_id','arrival','checkout','status'];
	 public function booking()
    {
      
       return $this->belongsTo('App\room');
    }
  
}
