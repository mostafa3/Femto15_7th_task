<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JWTAuth;
use JWTFactory;
use Auth;
use App\User;


// custom class for api authentication
class ApiAuthController extends Controller{


  public function register(Request $request){

    $request = $this->validateRequest($request,'register');

    $user = User::create($request);

    $token = JWTAuth::attempt(request()->only(['email','password']));


    return response()->json([
      'auth' => $this->respondWithToken($token),
      'api_key' => Auth::user()->key(),
    ],200);

  }



  public function login(Request $request){

      $this->validateRequest($request);

        $credentials = request(['email', 'password']);

        // show error message
        if (! $token = JWTAuth::attempt($credentials)) {
            return response()->json(['errors' => [
              'email' => ['Authentication failed']
              ]],401);
        }
        // return token and api_key for user
        return response()->json([
          'auth' => $this->respondWithToken($token),
          'api_key' => Auth::user()->key(),
        ],200);
    }



    public function logout()
    {
        JWTAuth::logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => JWTFactory::getTTL() * 60
        ]);
    }

    public function validateRequest(Request $request, $type = ''){

      // validation for login
      $request->validate([
        'email' => 'required|email',
        'password' => 'required|min:5'
      ]);

      // additional validation for register
      if($type == 'register'){
        $request->validate([
          'name' => 'required|min:3',
          'email' => 'unique:users,email'
         ]);
      }

      return $request->all();
    }

}
