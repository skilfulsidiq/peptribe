<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use Socialite;

class PassportController extends Controller
{
    //
    public $successStatus = 200;

    //login api
    public function login(){
    	if (Auth::attempt(['email'=>request('email'),'password'=>request('password')])) {
    		
    		$user = Auth::user();
    		$success['token'] = $user->createToken('MyApp')->accessToken;

    		return response()->json(['success'=>$success], $this->successStatus);
    	}else{
    		return response()->json(['error'=>'Unauthorised'], 401);
    	}
    }

    public function register(Request $request){
    	$validator = Validator::make($request->all(), [
    		'name'=>'required',
    		'email'=>'required',
    		'password'=>'required',
    		'c_password'=>'required|same:password'
    	]);

    	if($validator->fails()){
    		return response()->json(['error'=>$validator], 401);
    	}

    	$input = $request->all();
    	$input['password'] =bcrypt($input['password']);
    	$user = User::create($input);
    	$success['token'] = $user->createToken('MyApp')->accessToken;
    	$success['name']= $user->name;
    	return response()->json(['success'=>$success], $this->successStatus);

    }

    public function getDetails(){
    	$user = Auth::user();
    	return response()->json(['success'=>$user], $this->successStatus);
    }
    //social login

    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

     public function handleProviderCallback($provider)
    {

    	// if provider access is not granted, redirect back to login page
	    if (Input::get('denied') != '') {
	    	return redirect()->route('/login');
	    }

        $user = Socialite::driver($provider)->user();

        $authUser = $this->findOrCreateUser($user, $provider);
        Auth::login($authUser, true);
        return redirect($this->redirectTo);
    }
    public function findOrCreateUser($user, $provider)
    {
        $authUser = User::where('provider_id', $user->id)->first();
        if ($authUser) {
            return $authUser;
        }
        return User::create([
            'name'     =>$user->name,
            'email'    =>$user->email,
            'provider' =>$provider,
            'provider_id' =>$user->id
        ]);
    }
}
