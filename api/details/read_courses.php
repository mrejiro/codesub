<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
  
// include database and object files
include_once '../../config/database.php';
include_once './../objects/courses.php';
include_once './../objects/sessions.php';
// instantiate database and courses object
$database = new Database();
$db = $database->getConnection();
  
// initialize object
$courses_assessment = new Courses($db);
  
// query courses
$stmt = $courses_assessment->read_allcourses();
$num = $stmt->rowCount();
$eid = $courses_assessment->employee_id = isset($_GET['eid']) ? $_GET['eid'] : die();
$charset = 'UTF-8';

// check if more than 0 record found
if($num>0){
  
    // employee array
    $courses_array=array();
    $courses_array["records"]=array();
  
    // retrieve our table contents
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
  
        $course_item=array(
            "course_id" => $course_id,
            "course_title" => $course_title,
            "employee_progress" => $courses_assessment->employee_progress($eid, $course_id, 109),
            "course_type" => html_entity_decode($course_type)
        );
  
        array_push($courses_array["records"], $course_item);
      
    }
  
    // set response code - 200 OK
    http_response_code(200);
    //usort($courses_array, 'comparator');
    // show courses data in json format
    echo json_encode($courses_array);
}else{
  
    // set response code - 404 Not found
    http_response_code(404);
  
    // tell the user no courses found
    echo json_encode(
        array("message" => "No Courses found.")
    );
}
