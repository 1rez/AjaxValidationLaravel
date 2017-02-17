<?php

namespace App\Helpers;

use Illuminate\Http\Request;
use JWTAuth;

class ApiAuth {
    protected $request;

    protected $method;

    public function __construct(Request $request){
        $this->request = $request;
        $this->setMethod("session");
    }

    public function setMethod($method){
        if($method != null){
            $this->method = $method;
        }else{
            $this->method = 'session';
        }
    }

    public function getToken(){
        $method = $this->method;
        $token = null;

        if($method == 'session'){
            $token = $this->request->session()->get('token');
        }else if($method == 'query'){
            $token = $this->request->query('token', false);
        }

        return $token;
    }

    public function logout(){
        if($this->getToken() != null){
            $result = JWTAuth::invalidate($this->getToken());
            $this->request->session()->regenerate();
            return $result;
        }
        return null;
    }

    public function getUser(){
        if($token = $this->getToken()){
            $user = JWTAuth::toUser($token);
            if($user != null)
                return $user;
        }
        return null;
    }

    public function userAuthenticated(){
        if($token = $this->getToken()){
            $user = JWTAuth::toUser($token);
            if($user != null)
                return true;
        }
        return false;
    }

}
