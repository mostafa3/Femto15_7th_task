<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class SettingsController extends Controller
{

  public function __construct(){
    $this->middleware('jwt.auth');
  }

  // save the api key for user
  // don't call this method if the key is invalid
  public function setApiKey(Request $request){
      $request = $this->validateRequest($request);
      Auth::user()->update_key($request['key']);
    return response()->json(['api_key'=> $request['key'] ],200);
  }


  public function validateRequest(Request $request){
    return $request->validate([
        'key' => 'required'
    ]);
  }


}
