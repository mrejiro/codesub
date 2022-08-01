<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  
// include database and object files
// include database and object files
include_once '../../config/database.php';
include_once '../../config/func.php';
include_once './../objects/employee.php';
  
// get database connection
$database = new Database();
$db = $database->getConnection();
  
// prepare Employee object
$Employee = new Employee($db);
  
// get id of employee to be edited
$data = json_decode(file_get_contents("php://input"));
  
// set ID property of employee to be edited
$Employee->employee_id=$data->employee_id;
  
// set property values
$Employee->employee_fname = $data->employee_fname;
$Employee->employee_lname  =$data->employee_lname;
$Employee->mname= $data->mname;
$Employee->employee_title= $data->employee_title;
$Employee->mobile_no=  $data->mobile_no;
$Employee->alt_mobile =   $data->alt_mobile;
$Employee->alt_email =   $data->alt_email;
$Employee->street_addy =  $data->street_addy;
$Employee->updated_acct =  $data->updated_acct;
//
$Employee->city= $data->city;
$Employee->postcode =   $data->postcode;
$Employee->country =   $data->country;
$Employee->emerg_fname =   $data->emerg_fname;
$Employee->emerg_lname=  $data->emerg_lname;
$Employee->emerg_relationship = $data->emerg_relationship;
$Employee->emerg_phone = $data->emerg_phone;
$Employee->emerg_address =  $data->emerg_address;

  
// update the employee record
if($Employee->updateemployee()){
  
    // set response code - 200 ok
    http_response_code(200);
  
    // tell the user
    echo json_encode(array("message" => "Employee data updated."));
}
  
// if unable to update the employee, tell the user
else{
  
    // set response code - 503 service unavailable
    http_response_code(503);
  
    // tell the user
    echo json_encode(array("message" => "Unable to update employee."));
}
?>