<?php
include_once 'employee.php';

class Courses{
  
    // database connection and table name
    private $conn;
    private $table_name = "courses";
  
    // object properties
    public $course_id;
    public $assessment_available;
    public $course_title;
    public $course_content;
    public $course_type;
    public $employee_id;
    private $tp = "employee_courses";
    public $progress;
    public $publish;
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
    



    public function checkifcourse_exist($employee_id, $courseid){
  
    // query to read single record
    $query = "SELECT * from 
             " . $this->table_progress . "
            WHERE 
            employee_id = :employee_id AND courseid=:courseid";
  
    // prepare query statement
    $stmt = $this->conn->prepare( $query );
    
  
    // bind id of courses to be updated
    $stmt->bindParam(':employee_id', $employee_id);
    $stmt->bindParam(':courseid', $courseid);
    // execute query
   
    $stmt->execute();
  
    // set values to object properties
    return $stmt;
}

public function insert_course_progress($eid, $cid){
  
    // query to insert record
    $query = "INSERT INTO
                " . $this->tp . "
            SET
            employee_id=:employee_id, courseid=:courseid";
  
    // prepare query
    $stmt = $this->conn->prepare($query);
  
    
    // bind values
    $stmt->bindParam(":employee_id", $eid);
    $stmt->bindParam(":courseid", $cid);
  
    // execute query
    if($stmt->execute()){
        return true;
    }
  
    return false;
      
}
    // read courses
 
    public function employee_progress($eid, $cid, $val_return){
  
        // query to read single record
        $query = "SELECT * from 
                 " . $this->table_progress . "
                WHERE 
                employee_id = :eid AND courseid = :cid LIMIT 1";
      
        // prepare query statement
        $stmt = $this->conn->prepare( $query );
        
      
        // bind id of product to be updated
        $stmt->bindParam(':eid', $eid);
        $stmt->bindParam(':cid', $cid);
      
        // execute query
       
        $stmt->execute();
      
        // get retrieved row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
      
        // set values to object properties and return either progress or date
        if($val_return == 109){
            return $this->progress = $row['progress'];
        }else{ 
            //return date
        return $this->progress = $row['last_updated'];
    }
}

   public function readOne(){
  
        // query to read single record
        $query = "SELECT * from courses where course_id= :cid";
      
        // prepare query statement
        $stmt = $this->conn->prepare( $query );
        
        // bind id of courses to be updated
        $stmt->bindParam(':cid', $this->course_id);
      
        // execute query
        $stmt->execute();
      
        // get retrieved row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
      
        // set values to object properties
        $this->course_id= $row['course_id'];
        $this->course_title = $row['course_title'];
        $this->course_content = $row['course_content'];
        $this->course_type = $row['course_type'];
        $this->assessment_available = $row['assessment_available'];
    }


   public function updateemployeeprogress($eid, $cid, $progres){
  
        // update query
        $query = "UPDATE
                    " . $this->table_progress . "
                SET
                progress = :progress
                WHERE
                employee_id = :employee_id AND courseid =:courseid ";
      
        // prepare query statement
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':progress', $progres);
        $stmt->bindParam(':employee_id', $eid);
        $stmt->bindParam(':courseid', $cid);
      
        // execute the query
        if($stmt->execute()){
            return true;
        }
      
        return false;
    }
        
}
?>