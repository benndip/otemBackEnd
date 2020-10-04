<?php

namespace App\Http\Controllers\UserAuth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    //
     //
     protected $user;
    
     public function __construct()
     {
        $this->middleware('auth:api', ['except' => ['login','register']]);
        $this->user = new User;
     }
    
    
    // Register function
     public function register(Request $request)
     {
       $this->validate($request,
        [
          'name'=>'required|string',
          'email'=>'required|email|unique:users,email',
          'phonenumber' =>'required|digits:9|unique:users,phonenumber',
          'password'=>'required|confirmed|string|min:6',
        ]);
    
       $registerComplete = $this->user::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'phonenumber' => $request->phonenumber,
            'password'=> Hash::make($request->password), 
        ]);
        
        // If register completes, then login the user
      if($registerComplete)
      {
         return $this->login($request);
      }   
     }
    
    
    
    //Login function
     public function login(Request $request)
     {
        $this->validate($request,
        [
            'email'=>'required|email',
            'password'=>'required|string|min:6',
        ]);
        $jwt_token = null;
    
        $input = $request->only("email","password");
    
        if(!$jwt_token = auth()->attempt($input))
        {
            return response()->json([
                'success'=>false,
                'message'=>'invalid email or password'
            ]);
    
          }
    
        return response()->json([
            'success'=>true,
            'user' =>$this->me()->original,
            'token'=>$jwt_token,
            'expires_in' => auth()->factory()->getTTL() * 60,
        ]);
    }
     
         //Get the authenticated user
        public function me()
        {
            return response()->json(auth()->user()->only(['id','name','email','status','phonenumber','type','avatar']));
        }
        
        //Logout the user(Invalidate the token)
        public function logout()
        {
            auth()->logout();
    
            return response()->json(['message' => 'Successfully logged out']);
        }
    
        //Refresh the token
        public function refresh()
    
        {
            return response()->json([
                'new_token'=>auth()->refresh(),
                'token_type' => 'bearer',
                'expires_in' => auth()->factory()->getTTL() * 60
            ]);
        }
    
        //update user's password
        public function updatePassword(Request $request){
            $this->validate($request,
            [
                'current_password' => 'required|string|min:6',
                'new_password' => 'required|confirmed|string|min:6'
            ]);
    
            $user = auth()->user();
            $check_password = password_verify($request->current_password,$user->password);
           
            if(!$check_password){
                return response()->json([
                    'success' => false,
                    'message' => 'Your Password is not correct'
                ],401);
            }elseif ($request->current_password == $request->new_password) {
                return response()->json([
                    'success' => false,
                    'message' => 'You can\'t change to the same password'
                ],401);
            }else {
                $obj_user = User::find($user->id);
                $obj_user->password = Hash::make($request->new_password);
                $obj_user->save(); 
                return response()->json([
                    'success' => true,
                    'message' => 'You successfully updated your password',
                    'user' =>$this->me()->original,
                ],200);
            }
        }
}
