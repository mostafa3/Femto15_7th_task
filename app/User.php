<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;



    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $fillable = [
         'name', 'email', 'password', 'api_key'
     ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function getJWTIdentifier(){
        return $this->getKey();
    }

    public function getJWTCustomClaims(){
        return [];
    }

    public function setPasswordAttribute($password){
        if ( !empty($password) ) {
            $this->attributes['password'] = bcrypt($password);
        }
    }

    public function key(){
      return $this->api_key;
    }

    public function update_key($key){
      $this->update(['api_key' => $key]);
    }

    public function valid_key($api_key){
      $this->update_key($api_key);
    }

    public function invalid_key(){
      $this->update_key('');
    }




}
