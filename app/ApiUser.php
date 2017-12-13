<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApiUser extends Model
{
    //
    protected $fillable = ['email','api_token'];

    // public function generateToken()
    // {
    //     $this->api_token = str_random(60);
    //     $this->save();

    //     return $this->api_token;
    // }
}
