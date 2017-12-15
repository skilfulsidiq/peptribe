<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Post extends Model
{
    // //
    //  protected $fillable = ['type','postformat','parentid',];
    protected $table = 'qa_posts';
    protected $primaryKey = 'postid';

   public function upvotes(){
        return $this->hasMany(Upvote::class);
    }

    public function downvotes(){
        return $this->hasMany(Downvote::class);
    }

    public function images(){
    	return $this->hasMany(Image::class);
    }
    public function videos(){
    	return $this->hasMany(Video::class);
    }

    public function points(){
        return $this->hasMany(LikePoint::class);
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }


   
}
