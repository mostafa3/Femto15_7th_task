<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Currency;
use validKey;
use App\User;

class CurrencyController extends Controller
{

  public function __construct(){
    $this->middleware('jwt.auth');
    $this->middleware('validKey');
  }

    public function getRates($pairs){
      // $currencies = $pairs['to_currencies']->pluck('short_name')->toArray();
      //
      // $currencies = implode( ',', $currencies);
      //
      // $link = 'http://apilayer.net/api/live?access_key='.Auth::user()->key().'&currencies='.$currencies;
      //
      // $client = new \GuzzleHttp\Client;
      //
      // $res = $client->request('GET', $link);
      //
      //
      // $data =   json_decode($res->getBody());

      return(["USDBMD"=>1,"USDBND"=>1.35075,"USDBYR"=>19600,"USDCAD"=>1.334555]);
      return($data->quotes);
    }

    public function getPairs(){
      $user = User::where('id',Auth::id())->with(['source_currencies','to_currencies'])->first();
      // $user = Auth::user();
// return $user;

      $pairs = [
        'source_currencies' =>  $user->source_currencies,
        'to_currencies'     =>  $user->to_currencies,
      ];

      if($pairs['source_currencies'])
        $pairs['rates'] = $this->getRates($pairs);

      return response()->json($pairs);
    }

    public function getCurrencies(){
        $source_currencies = Currency::where('short_name', 'USD')->get();
        $to_currencies = Currency::all()->diff($source_currencies);
        $currencies = [
          'source_currencies' => $source_currencies,
          'to_currencies' => $to_currencies
        ];
        return response()->json($currencies);
    }


    public function updateCurrency(Request $request){

        $this->validateRequest($request, true);



      $user = Auth::user();

      $user->source_currencies()->wherePivot('currency_2_id',$request->old_to)->detach($request->old_source);
      $user->source_currencies()->attach($request->source,['currency_2_id'=>$request->to]);

    }

    public function addPair(Request $request){
        $this->validateRequest($request);

      $user = Auth::user();

      $user->source_currencies()->wherePivot('currency_2_id',$request->to)->detach($request->source);
      $user->source_currencies()->attach($request->source,['currency_2_id'=>$request->to]);
    }

    public function deletePair(Request $request){
      $this->validateRequest($request);

      $user = Auth::user();
      $user->source_currencies()->wherePivot('currency_2_id',$request->to)->detach($request->source);

    }

    public function validateRequest(Request $request, $withOld = false){
      $request->validate([
        'source' => 'bail|required|exists:currencies,id',
        'to'=> 'required|exists:currencies,id',
      ]);

      if($withOld){
        $request->validate([
          'old_source' => 'bail|required|exists:currencies,id',
          'old_to' => 'required|exists:currencies,id',
        ]);
      }

    }


}
