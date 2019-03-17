<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JWTAuth;
use JWTFactory;
use Auth;


class ApiAuthController extends Controller
{

  public function register(Request $request)
  {

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
        $request->validate(['name'=>'required']);
      }
    }

}
