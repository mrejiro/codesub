<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  

// include database and object files
include_once '../../config/database.php';
include_once '../../config/func.php';
include_once './../objects/Employee.php';
  
$database = new Database();
$db = $database->getConnection();
  
$Employee_details = new Employee($db);
$new_pwd = $Employee_details->randomPassword();
$data = json_decode(file_get_contents("php://input"));
 // print_r($data);
// make sure data is not empty
if(!$Employee_details->checkifemail_exist($data->employee_email_signup) == $data->employee_email_signup){


if(
    !empty($data->employee_fname) &&
    !empty($data->employee_lname) &&
    !empty($data->mobile_no) &&
    !empty($data->employee_email_signup)
){
  
    // set employee property values
    $Employee_details->employee_fname = $data->employee_fname;
    $Employee_details->employee_lname = $data->employee_lname;
    $Employee_details->employee_email = $data->employee_email_signup;
    $Employee_details->postcode = $data->postcode;
    $Employee_details->mname = $data->mname;
    $Employee_details->mobile_no = $data->mobile_no;
    $Employee_details->employee_password = $new_pwd;


    if($Employee_details->createEmployee()){
  
        // set response code - 201 created
        http_response_code(201);
  
        // tell the user
        echo 1;//json_encode(array("message" => "Employee record was inserted."));
    }
  
    else{
  
        // set response code - 503 service unavailable
        http_response_code(503);
  
        // tell the user
        echo 2;//json_encode(array("message" => "Unable to create employee record."));
    }
}  
// tell the user data is incomplete
else{
  
    // set response code - 400 bad request
    http_response_code(400);
  
    // tell the user
    echo 3;//json_encode(array("message" => "Unable to create employee. Data is incomplete."));
}
}else{
    echo 4; //json_encode(array("message" => "Email Address Exists."));
}

?>