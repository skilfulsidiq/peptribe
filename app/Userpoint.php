<?php

namespace App;
use DB;
use App\Post;

use Illuminate\Database\Eloquent\Model;

class Userpoint extends Model
{
    //
    protected $table = 'userpoints';
    protected $fillable = ['user_id','points'];

    public function user(){
    	return $this->belongsTo(User::class);
    }

   public function incrementpoint($user_id, $number=1){

        $db = DB::table('userpoints')->where(['user_id'=>$user_id])->first();
        // dd($db);
        if (empty($db->user_id)) {
        	$points = new Userpoint;
            $points->user_id = $user_id;
            $points->points = 1;
            $points->save();
        }else{
            $db = Userpoint::where(['user_id'=>$user_id])->first();
            $db->increment('points',$number);
        }
    return;
    }

     public function decrementpoint($user_id, $number=1){

      $db = DB::table('userpoints')->where(['user_id'=>$user_id])->first();
        if (empty($db->user_id)) {
        	$points = new Userpoint;
            $points->user_id = $user_id;
            $points->points = 1;
            $points->save();
        }else{
            $db = Userpoint::where(['user_id'=>$user_id])->first();
            $db->decrement('points',$number);
        }
    return;
    }
    		
    
    
    	
}
