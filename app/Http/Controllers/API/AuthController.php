<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use Socialite;

class AuthController extends Controller
{
    //
    public $successStatus = 200;

    //login api
    public function login(Request $request){
    	if (Auth::attempt(['email'=>request('email'),'password'=>request('password')])) {
    		
    		$user = Auth::user();
    		$data = ['status' => "Login successfully", 'data' => $user];
            return response()->json($data);

    		// return response()->json(['success'=>$success], $this->successStatus);
    	}else{
            // $data = ['status' => 'Unauthorize, Invalid email or password', 'data' => $user];
            return response()->json(['status' => 'Unauthorize, Invalid email or password'],401);
    	
    	}
    }

    public function register(Request $request){
        $type = $request->get('type');

        $input = $request->all();
             if($type =='email_reg'){
                $validator = Validator::make($request->all(), ['name'=>'required','email'=>'required','password'=>'required']);
                if($validator->fails()){
                    return response()->json(['status'=>$validator], 401);
                }
               $user = User::where(['email'=>$input['email']])->first();
                if(!empty($user->email)) {
                    $data = ['status' => 'User Already Exist', 'data' => $user];
                    return response()->json($data,401);
                }
                $input['password'] =bcrypt($input['password']);
                $user = User::create($input);  
                $data = ['status' => "Registeration successfully", 'data' => $user];
                return response()->json($data); 
            }
            if ($type =='social_reg') {
                    if(!empty($input['gmail_id'])){
                        $user = User::where(['gmail_id'=>$input['gmail_id']])->first();
                        if (!empty($user->gmail_id)) {
                            $data = ['status' => 'User Already Exist', 'data' => $user];
                            return response()->json($data,401);
                            }
                    }
                    if(!empty($input['fb_id'])){
                        $user = User::where(['fb_id'=>$input['fb_id']])->first();
                        if (!empty($user->fb_id)) {
                            $data = ['status' => 'User Already Exist', 'data' => $user];
                            return response()->json($data,401);
                        }
                    }
                $user = User::create($input);  
                $data = ['status' => "success", 'data' => $user];
            return response()->json($data);       
            }
           
         
    	
    	
        //  $this->validator($request->all())->validate();

        // event(new Registered($user = $this->create($request->all())));

        // $this->guard()->login($user);
        
    	

    }

    public function logout(Request $request)
    {
        $this->guard()->logout();

        // $request->session()->invalidate();

        return redirect('/');
    }

   
}
