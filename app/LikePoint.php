<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LikePoint extends Model
{
    //
    protected $fillable = ['post_id','points'];

    public function post(){
    	return $this->belongsTo(Post::class);
    }
}
