<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Downvote extends Model
{
    //
     public function user(){
    	return $this->belongsTo(User::class);
    }

     public function post(){
    	return $this->belongsTo(Post::class);
    }
}
