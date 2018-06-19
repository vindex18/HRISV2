<?php

$app->post('/employees', 'EmployeeController:addEmployee'); //Add
$app->get('/employees/employeerecord/{str}', 'EmployeeController:getEmployee'); //Get Single Emp Rec //{emp_id:[0-9]+}
$app->delete('/employees/employeerecord/{str}', 'EmployeeController:deleteEmployee'); //Delete Single Emp Rec
$app->put('/employees/updateemployee/{str}', 'EmployeeController:updateEmployee'); //Update Single Emp Rec
$app->get('/employees[/{accstat:[0-9]+}]', 'EmployeeController:getAllEmployee'); //Get All Emp Rec 