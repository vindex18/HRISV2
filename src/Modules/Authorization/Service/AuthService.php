<?php

namespace App\Modules\Authorization\Service;
use App\Modules\Authorization\Models\AuthModel;
use Respect\Validation\Validator as v;
use App\Utils\Validator;
use \Datetime;
use \Firebase\JWT\JWT;
use \Tuupola\Base62;
use App\Middleware\Auth;

class AuthService {
    function validatecredentials($req, $res){
        $validation = Validator::validate($req, [
            'password' => v::noWhitespace()->notEmpty()->length(6, null),
            'email' => v::noWhitespace()->notEmpty()->email(),
        ]); 
        
        if(!is_null($validation))
            //var_dump($validation);
            return $validation;
            
        $userexists = AuthModel::where('email', '=', strip_tags($req->getParam('email')))->first();

        if(is_null($userexists))
            return array('status' => 'val_error', 'msg' => 'Email doesn\'t exists!', 'tk' => '');
        else{
            if($userexists->is_active)
            {
                if(password_verify(strip_tags($req->getParam('password')), $userexists->password))
                    //var_dump('User Authentication Succeeded!'); 
                    return array('status' => 'success', 'msg' => 'Auth Success', 'tk' => AuthService::generate_jwt($req, $res, $userexists->email));
                else
                    //var_dump("User Authentication Failed!");
                    return array('status' => 'failed', 'msg' => 'Incorrect Email/Password!', 'tk' => '');
            }
            else
            {
                //var_dump('User Account Deactivated');
                return array('status' => 'deactivated', 'msg' => 'Account Deactivated! Contact The Administrator!', 'tk' => ''); 
            }
        }
    }

    function generate_jwt($req, $res, $email){
        $now = new DateTime();
        //$future = new DateTime("now +2 hours");
        $future = new DateTime("now +1 day");
        $base62 = new \Tuupola\Base62;

        $payload = [
            'iat' => $now->getTimeStamp(), //issued at
            //'exp' => $now->createFromFormat('d/m/Y H:i:s', '23/05/2013'), 
            'exp' => $future->getTimeStamp(), //expiration
            'jti' => $base62->encode(random_bytes(32)), //json token id
            'sub' => $email, //subject
            'iss' => $base62->encode("invento-hris") //issuer
        ];

        $secret = Auth::jwtSecret();
        return JWT::encode($payload, $secret, "HS256");
        /*$jwt = JWT::encode($payload, $secret, "HS256");
        $decoded = JWT::decode($jwt, $secret, array('HS256'));

        print_r($decoded);
        die();*/

       
    }

}