<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JWTAuth;
use JWTFactory;
use Auth;
use App\User;

class ApiAuthController extends Controller{

  public function register(Request $request){

    $request = $this->validateRequest($request,'register');

    $user = User::create($request);

    $token = JWTAuth::attempt(request()->only(['email','password']));

    return $this->respondWithToken($token);
  }



  public function login(Request $request)
    {
      $this->validateRequest($request);

        $credentials = request(['email', 'password']);

        if (! $token = JWTAuth::attempt($credentials)) {
            return response()->json(['errors' => [
              'email' => ['Authentication failed']
              ]],401);
        }
        return response()->json([
          'auth' => $this->respondWithToken($token),
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

      $request->validate([
        'email' => 'required|email',
        'password' => 'required|min:5'
      ]);

      if($type == 'register'){
        $request->validate([
          'name' => 'required|min:3',
          'email' => 'unique:users,email'
         ]);
      }

      return $request->all();
    }

}
