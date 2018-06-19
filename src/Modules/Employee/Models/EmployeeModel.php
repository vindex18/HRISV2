<?php

namespace App\Modules\Employee\Models;
use Illuminate\Database\Capsule\Manager as DB;
use Illuminate\Database\Eloquent\Model;

//use Illuminate\Database\Eloquent\SoftDeletes; 

class EmployeeModel extends Model {

    //use SoftDeletes;

    protected $table = 'employees';
    protected $primaryKey = 'id';
    protected $fillable = [
        'first_name',
        'last_name',
        'middle_name',
        'phone',
        'email',
        'address',
        'pos_title',
        'password',
        'is_active'
    ];
}