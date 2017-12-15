<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use DB;

class User extends Authenticatable
{
    use HasApiTokens,Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
         'name', 'email','phone', 'password', 'provider', 'provider_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function upvotes(){
        return $this->hasMany(Upvote::class);
    }

    public function downvotes(){
        return $this->hasMany(Downvote::class);
    }


    public function generateToken()
    {
        $this->api_token = str_random(60);
        $this->save();

        return $this->api_token;
    }

    public function userpoints(){
        return $this->hasMany(Userpoint::class);
    }
    public function comments(){
        return $this->hasMany(Comment::class);
    }

       public function incrementpoint($userid, $number=1){

        $db = DB::table('users')->where(['id'=>$userid])->first();
        // dd($db);
        if (empty($db->id)) {
            $points = new User;
            $points->id = $userid;
            $points->points = 1;
            $points->save();
        }else{
            $db = User::where(['id'=>$userid])->first();
            $db->increment('points',$number);
        }
    return;
    }

     public function decrementpoint($userid, $number=1){

        $db = DB::table('users')->where(['id'=>$userid])->first();
        if (empty($db->id)) {
            $points = new User;
            $points->id = $userid;
            $points->points = 1;
            $points->save();
        }else{
            $db = User::where(['id'=>$userid])->first();
            $db->decrement('points',$number);
        }
    return;
    }

}
