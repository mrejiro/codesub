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

$save_rota = new Employee($db);
$data = file_get_contents("php://input");
//$newdata = json_decode($data, true);


$data_decoded = json_decode(($data), true);
foreach($data_decoded as $key => $item) {
    $str = substr($key, 0, strrpos($key, '@'));
    
   
    $new_date = str_replace('%', '', strstr($key, '%'));
     $format_date = date('Y/m/d', strtotime($new_date));
    //str=line_id
    //item=employee_id
   // echo $str.'='.$item.',';
    $save_rota->employee_id = $item;
    $save_rota->line_id = $str;
    $save_rota->date_created = $format_date;

    if($save_rota->SaveRota()){
        http_response_code(201);
  
        // tell the user
     $done = true;//json_encode(array("message" => "Employee record was inserted."));
    } 
}
if($done){
    echo 1;
} 
?>