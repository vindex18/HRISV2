<?php 

namespace App\Modules\Employee\Dao;
use App\Modules\Employee\Models\EmployeeModel;
use Illuminate\Database\Capsule\Manager as DB;

class EmployeeDao {
    function getAllEmployee($accstat){
        return EmployeeModel::select('first_name', 'middle_name', 'last_name', 'phone', 'email', 'address', 'pos_title', 'is_admin', 'created_at','updated_at', 'is_active')->whereRaw($accstat)->orderBy('created_at', 'DESC')->get();
    }

    function addEmployee($arr){
        return EmployeeModel::firstOrcreate($arr)->save();
    }
    
    function checkEmailExistsOnAddEmployee($email){
        return EmployeeModel::where('email', '=', strip_tags($email))->where('is_active', '=', 1)->first();
    }

    function deleteEmployee($emp_id){
        $emp = EmployeeDao::getEmployee($emp_id);
        $name = $emp['last_name'].", ".$emp['firstname']." ".$emp['middlename'];
        $qry = EmployeeModel::where('id', $emp_id)->delete();
        return ($qry) ? array('msg' => 'Employee Deleted Successfully! ('.$name.')', 'status' => true) : array('msg' => 'Error Encountered on Employee Deletion! ('.$name.')', 'status' => false);
    }

    function getEmployee($emp_id){
        return EmployeeModel::select('first_name', 'middle_name', 'last_name', 'phone', 'email', 'address', 'pos_title', 'is_admin', 'created_at','updated_at', 'is_active')->where('id', $emp_id)->first()->toArray();
    }

    function getMinimumDTOfEmployeeAttendance(){
        $qry = DB::table('attendance')
               ->orderBy('id', 'DESC')
               ->limit(1)
               ->select('datetime')
               ->get();

        if(is_null($qry))
            return date('Y-m-d 00:00:00');
    }
}