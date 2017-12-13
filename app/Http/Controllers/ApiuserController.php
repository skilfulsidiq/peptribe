<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ApiUser;
use Validator;
use Illuminate\Support\Facades\Auth;

class ApiuserController extends Controller
{
    //

     public function register(Request $request){
    	$validator = Validator::make($request->all(), [
    		'email'=>'required'
    	]);

    	if($validator->fails()){
    		return response()->json(['error'=>$validator], 401);
    	}

    	$apiuser = Apiuser::create([
    		'email'=>$request->get('email'),
    		'api_token' => str_random(60)

    	]);
    	// $apiuser->generateToken();
    	$apiuser->save();

    	// $input = $request->all();
    	// $input['api_token'] = str_random(60);
    	// // $input['password'] =bcrypt($input['password']);
    	// $Apiuser = ApiUser::create($input);
    	return response()->json();

    }
}
