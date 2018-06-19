<?php

namespace App\Modules\Employee\Service;

use App\Modules\Employee\Models\EmployeeModel;
use App\Modules\Employee\Dao\EmployeeDao;
use Respect\Validation\Validator as v;
use App\Utils\Validator;

class EmployeeService {
    function __construct($container){
      
    }

    function getAllEmployee($req, $res){
        $accstat = strip_tags($req->getAttribute('accstat'));
        (!empty($accstat)) ? 
            ($accstat==1) ?
                $accstat = "is_active = ".$accstat : $accstat = "is_active = 0" : $accstat = "is_active IS NOT NULL" ;

        return EmployeeDao::getAllEmployee($accstat);
    }

    function deleteEmployee($req, $res){
        $emp_id = base64_decode(urldecode($req->getAttribute('str')));

        return (is_numeric($emp_id)) ? EmployeeDao::deleteEmployee($emp_id) : null;
    }

    function updateEmployee($req, $res){
        $validation = Validator::validate($req, [
            'firstname' => v::notEmpty()->alpha(),
            'lastname' => v::notEmpty()->alpha(),
            'password' => v::noWhitespace()->notEmpty()->length(6, null),
            'email' => v::noWhitespace()->notEmpty()->email(),
        ]);    
    }

    function addEmployee($req, $res){
       
        $validation = Validator::validate($req, [
            'firstname' => v::notEmpty()->alpha(),
            'lastname' => v::notEmpty()->alpha(),
            'password' => v::noWhitespace()->notEmpty()->length(6, null),
            'email' => v::noWhitespace()->notEmpty()->email(),
        ]); 

        if(!is_null($validation))
           return $res->withJSON($validation);
        
        $userexists = EmployeeDao::checkEmailExistsOnAddEmployee(strip_tags($req->getParam('email')));

        if(!is_null($userexists)){
            return array('status' => false, 'msg' => 'Email Already Exists!'); 
        }
        else{
      
            $arr = [
                'first_name' => strip_tags($req->getParam('firstname')), 
                'last_name' => strip_tags($req->getParam('lastname')),
                'middle_name' => strip_tags($req->getParam('middlename')),
                'phone' => strip_tags($req->getParam('phone')),
                'email' => strip_tags($req->getParam('email')),
                'address' => strip_tags($req->getParam('address')),
                'pos_title' => strip_tags($req->getParam('postitle')),
                'password' => password_hash(strip_tags($req->getParam('password')), PASSWORD_DEFAULT),
                'is_active' => 1
            ];
            
            return (EmployeeDao::addEmployee($arr)) ? array('status' => true, 'msg' => "Employee Added Successfully!") : array('status' => false, 'msg'=> 'Failed to Create New Employee!');
        }
    }

    function getEmployee($req, $res, $args){
        $emp_id = base64_decode(urldecode($req->getAttribute('str')));
        return (is_numeric($emp_id)) ? EmployeeDao::getEmployee($emp_id) : null;
    }
}
