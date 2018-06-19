<?php

namespace App\Middleware;
use \Firebase\JWT\JWT;
use \Tuupola\Base62;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\SignatureInvalidException;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

/*
    jwtSecret function holds the secret key
*/

class Auth {
    function __construct(){
        //var_dump('Auth Middleware Constructed!<br>');
        //echo urlencode(base64_encode(1)); die();
    }

    function __invoke(Request $req, Response $res, $next){
        $res->withHeader('Content-type', 'application/json');
        
        //var_dump('Auth Middleware Invoked!<br>');
        //return $next($req, $res);
         
        $route = $req->getAttribute("route");
        $token = false;
        //var_dump($route); die("<br>Done");
        //$route->getPattern() == "/exec/book"
        //var_dump($req->getUri()->getPath()); die();
        //if($route->getUri()->getPath()->getPattern() == "/authorization/validatecredentials")

        if(isset($route)&&!empty($route)&&$route->getPattern() == "/authorization/validatecredentials") //User trying to login
        {       
            //echo "For Login";
            return $next($req, $res);
        }
        else //Secured Requests
        {
           //die("X");
           if($req->hasHeader('Authorization')&&isset($req->getHeader('Authorization')[0])&&!empty($req->getHeader('Authorization')[0])){
                $key = Auth::jwtSecret(); //Get Secret Key
                $payload = $req->getHeader('Authorization')[0];
                $authorization = explode(".", $req->getHeader('Authorization')[0]);
                //echo "Has Header";
                $token = $authorization[1];
                //Evaluate Authentication
                if($token) {
                    //echo "Evaluating...";
                    try {
                        $jwt = JWT::decode($payload, $key, ['HS256']);
                        return $next($req, $res);
                    } catch (ExpiredException $ex) {
                        return $res->withJSON(['message' => 'Token expired'], 401);
                    } catch(SignatureInvalidException $ex){
                        return $res->withJSON(['message' => 'Unauthorized Request', 'token' => $token], 401);
                    } catch(Exception $e){
                        return $res->withJSON(['message' => 'Unauthorized Request', 'token' => $token], 401);
                    }
                }
                else
                {
                    //No Token
                    return $res->withJSON(['message' => 'Unauthorized Request', 'token' => $token], 401);
                }
            }
            else
            {
                //echo "No Header and/or Value";
                return $res->withJSON(['message' => 'Unauthorized Request', 'token' => $token], 401);
            }
        }
        return $res->withJSON(['message' => 'Unauthorized Request', 'token' => $token], 401);
    }
    
    function jwtSecret(){
        return "Q!w12x2512g1c2a4Wa23Kpb752x&95z*";
    }

    function validatejwt(Request $req, Response $res){
        //$key = "Q!w12x2512g1c2a4Wa23Kpb752x&95z*";
        //$jwt = JWT::encode($payload, $secret, "HS256");
        //$decoded = JWT::decode($jwt, $key, array('HS256'));
        /*print_r($decoded);
        die();
        */
    }
}