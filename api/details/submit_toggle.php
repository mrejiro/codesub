<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


include_once '../../config/database.php';
include_once './../objects/Employee.php';
  
$database = new Database();
$db = $database->getConnection();

$insert_toggle = new Employee($db);
$assessment_type = $_GET['assessment_type'];
if($assessment_type == 1){
    $columnupdate = "update_health";
}else{
    $columnupdate = "update_medical";
}
$updateonefield = $insert_toggle->updateonefieldemployee($columnupdate, "1", $_GET['eid']);
$data = file_get_contents("php://input");
 //$newdata = json_decode($data, true);

$data_decoded = json_decode(($data), true);
//echo gettype($tpe);

foreach($data_decoded as $key => $item) {
    $rplace_textboxdata = str_replace("textboxdata","",$key);

    $insert_toggle->employee_id = $_GET['eid'];
    $insert_toggle->toggle_question = $rplace_textboxdata;
    $insert_toggle->toggle_answer = $item;
    if($insert_toggle->SaveToggleAnswers()){
        http_response_code(201);
  
        // tell the user
     $done = true;//json_encode(array("message" => "Employee record was inserted."));
    } 
}
 if($done){
    echo 1;
} 