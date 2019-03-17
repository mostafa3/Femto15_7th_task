<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SendController extends Controller
{

  public function __construct(){
    $this->middleware('jwt.auth');
  }
  
  public function checkUserKey(Request $request){

    $key = $request->key;
    $link = 'http://apilayer.net/api/live?access_key='.$key;

    $client = new \GuzzleHttp\Client;

    $res = $client->request('GET', $link);

    $data =   json_decode($res->getBody());

    if($data->success == false){
      $response['errors'] = array('key'=>[$data->error->type]);
      return response()->json($response,401);
    }else
      return response()->json(['status'=>'ok'],200);

  }


}
