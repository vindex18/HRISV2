<?php
 
namespace App\Modules\Attendance\Service;
use App\Modules\Attendance\Models\AttendanceModel;
use App\Modules\Attendance\Dao\AttendanceDao;
use Respect\Validation\Validator as v;
use App\Utils\Validator;

class AttendanceService {
    function getAllEmployeeAttendance($req, $res){
        //return AttendanceModel::all()->toArray(); getQueryParams()
        //Unix Timestamps from GET Param
        $dtfrom = date('Y-m-d H:i:s', strip_tags($req->getAttribute('dtfrom')));
        $dtto = date('Y-m-d H:i:s', strip_tags($req->getAttribute('dtto')));
        $accstat = strip_tags($req->getAttribute('accstat'));
       
        if(empty($dtfrom))
            $dtfrom = AttendanceDao::getMinimumDTOfEmployeeAttendance();
            
        if(empty($dtto))
            $dtto = AttendanceDao::getMaximumDTOfEmployeeAttendance();

        (empty($accstat)) ? $accstat = "is_active IS NOT NULL" : $accstat = "is_active = ".$accstat;
 
        $data =  AttendanceDao::getAllEmployeeAttendance($dtfrom, $dtto, $accstat)->toArray();

        echo "From: ".date('M d, Y g:i A', strtotime($dtfrom))." To: ".date('M d, Y g:i A', strtotime($dtto))."<br>";
        for($c=0;$c<count($data);$c++){
            echo $data[$c]->last_name.", ".$data[$c]->first_name."<br>";
            echo $data[$c]->pos_title."<br>";
            echo date('M d, Y g:i A', strtotime($data[$c]->datetime))." - ".$data[$c]->description." - ".$data[$c]->code."<br>";

        }
        die();
    }

    function addAttendance($req, $res){
        $validation = Validator::validate($req, [
            'id' => v::notEmpty(),
            'tag' => v::notEmpty(),
            'datetime' => v::notEmpty()
        ]); 
        
        if(!is_null($validation))
           return $validation;
        
        //var_dump($req->getParams()); die();
        $emp_id = strip_tags(base64_decode(urldecode($req->getParam('id'))));
        $type_id = strip_tags($req->getParam('tag'));
        $datetime = date('Y-m-d H:i:s', strtotime($req->getParam('datetime')));
        return (is_numeric($emp_id)) ? AttendanceDao::addAttendance($type_id, $emp_id, $datetime) : null;
    }

    function getEmployeeAttendance($req, $res){ 
        //$dtfrom = date('Y-m-d H:i:s', strip_tags($req->getAttribute('dtfrom')));
        //$dtto = date('Y-m-d H:i:s', strip_tags($req->getAttribute('dtto')));
        $dtfrom = date('Y-m-d', strip_tags($req->getAttribute('dtfrom')));
        $dtto = date('Y-m-d', strip_tags($req->getAttribute('dtto')));
 
        $emp_id = base64_decode(urldecode($req->getAttribute('emp_id')));

        echo "From: ".date('M d, Y', strtotime($dtfrom))." To: ".date('M d, Y', strtotime($dtto))."<br>";
        return (is_numeric($emp_id)) ? AttendanceDao::getEmployeeAttendance($dtfrom, $dtto, $emp_id) : null;
    }

    function deleteEmployeeAttendance($req, $res){
        $att_id = base64_decode(urldecode($req->getAttribute('att_id')));
        //$att_id = strip_tags($req->getAttribute('att_id'));
        return (is_numeric($att_id)) ? AttendanceModel::where('id', $att_id)->delete() : null;
    }
}

