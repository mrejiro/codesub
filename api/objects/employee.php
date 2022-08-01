<?php
class Employee{

    private $conn;
    private $table_name = "employee";
  
    // object properties
    public $employee_email;
    public $employee_password;
    public $employee_id;
    public $line_id;
    public $date_created;
    
    public $employee_fname;
    public $employee_lname;
    public $mname;
    public $updated_acct;
    public $update_right;
    public $update_health;
    public $update_medical;
    public $employee_title;
    public $mobile_no;
    public $alt_mobile;
    public $alt_email;
    public $street_addy;
    public $toggle_id;
    public $toggle_type;
    public $toggle_question;
    public $toggle_answer;
    //
    public $city;
    public $postcode;
    public $country;
    public $emerg_fname;
    public $emerg_lname;
    public $emerg_relationship;
    public $emerg_phone;
    public $emerg_address;
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
   /* 
   Query to select from employee table and progress table
   SELECT * FROM employee AS
     B LEFT JOIN employee_courses AS A
      ON A.employee_id = B.employee_id  WHERE A.employee_id = 2 */
    public function CheckEmployeeExists(){
        $query = "SELECT employee_email,employee_password,employee_id from employee where
         employee_email= :employee_email AND employee_password= :employee_password";

        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(':employee_email', $this->employee_email);
        $stmt->bindParam(':employee_password', $this->employee_password);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->employee_email = $row['employee_email'];
        $this->employee_password = $row['employee_password'];
        $this->employee_id = $row['employee_id'];

        if($stmt->execute()){
            return true;
        }
      
        return false;





    }
    
   

    public function checkifemail_exist($employee_email){
  
        // query to read single record
        $query = "SELECT * from 
                 " . $this->table_name . "
                WHERE 
                employee_email = :employee_email LIMIT 1";
      
        // prepare query statement
        $stmt = $this->conn->prepare( $query );
        
      
        // bind id of courses to be updated
        $stmt->bindParam(':employee_email', $employee_email);
      
        // execute query
       
        $stmt->execute();
      
        // get retrieved row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
      
        // set values to object properties
        return $this->employee_email = $row['employee_email'];
    }



    public function getOneemployee(){
  
        // query to read single record
             $query = "SELECT * from employee where employee_id= :employee_id";
      
            // prepare query statement
            $stmt = $this->conn->prepare( $query );
        
            // bind id of employee to be selected
            $stmt->bindParam(':employee_id', $this->employee_id);
          
            // execute query
            $stmt->execute();

            //
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
             // set values to object properties
            $this->employee_email = $row['employee_email'];
            $this->employee_id = $row['employee_id'];
            $this->employee_fname = $row['employee_fname'];
            $this->employee_lname  =$row['employee_lname'];
            $this->mname=   $row['mname'];
            $this->employee_title=   $row['employee_title'];
            $this->mobile_no=  $row['mobile_no'];
            $this->alt_mobile =   $row['alt_mobile'];
            $this->alt_email =   $row['alt_email'];
            $this->street_addy =  $row['street_addy'];
            $this->updated_acct =  $row['updated_acct'];
            $this->update_medical =  $row['update_medical'];
            $this->update_health =  $row['update_health'];
            $this->update_right =  $row['update_right'];
            //
            $this->city=   $row['city'];
            $this->postcode =   $row['postcode'];
            $this->country =   $row['country'];
            $this->emerg_fname =   $row['emerg_fname'];
            $this->emerg_lname=  $row['emerg_lname'];
            $this->emerg_relationship = $row['emerg_relationship'];
            $this->emerg_phone = $row['emerg_phone'];
            $this->emerg_address =  $row['emerg_address'];


    }
    public function checklistImage($val){
        if($val == 1){
              return ' <img src="images/check.png" width="30px" height="30px"/>';  
        }else{
             return ' <img src="images/failed.png" width="30px" height="30px"/>';
        }
        
    }
    public function getall_lines(){
  
        // query to read single record
        $query = "SELECT * from lines_tb ORDER BY line_name ASC";
      
        // prepare query statement
        $stmt = $this->conn->prepare( $query );
    
      
        // execute query
        $stmt->execute();
      
      
        return $stmt;

    }
    public function getallemployee(){
  
        // query to read single record
        $query = "SELECT * from employee ORDER BY employee_fname ASC";
      
        // prepare query statement
        $stmt = $this->conn->prepare( $query );
    
      
        // execute query
        $stmt->execute();
      
      
        return $stmt;

    }
    public function gettoggle_questions(){
  
        // query to read single record
        $query = "SELECT * from toggle_questions where toggle_type=:toggle_type ORDER BY toggle_name ASC";
      
        // prepare query statement
        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(':toggle_type', $this->toggle_type);
      
        // execute query
        $stmt->execute();
      
      
        return $stmt;

    }

    public function SaveRota(){

        // query to insert record
                  $query = "INSERT INTO
                  saved_rota
                  SET
                  employee_id=:employee_id, line_id=:line_id
                  , date_created=:date_created;";
      
                  // prepare query
                  
                  $stmt = $this->conn->prepare($query);
      
                  
                 
                  $this->employee_id=htmlspecialchars($this->employee_id);
                  $this->line_id=htmlspecialchars($this->line_id);
                  $this->date_created=htmlspecialchars($this->date_created);
                  // bind values
                  $stmt->bindParam(":employee_id", $this->employee_id);
                  $stmt->bindParam(":line_id", $this->line_id);
                  $stmt->bindParam(":date_created", $this->date_created);
                  // execute query
                  if($stmt->execute()){
                  return true;
                  }
      
                  return false;
      
      
          }





          public function SaveToggleAnswers(){

        // query to insert record
                  $query = "INSERT INTO
                  toggle_answers
                  SET
                  employee_id=:employee_id, toggle_question=:toggle_question
                  , toggle_answer=:toggle_answer ON DUPLICATE KEY UPDATE employee_id =VALUES(employee_id),
                   toggle_question = VALUES(toggle_question);";
      
                  // prepare query
                  $stmt = $this->conn->prepare($query);
      
                  // sanitize
                  $this->employee_id=htmlspecialchars($this->employee_id);
                  $this->toggle_question=htmlspecialchars($this->toggle_question);
                  $this->toggle_answer=htmlspecialchars($this->toggle_answer);
      
                  // bind values
                  $stmt->bindParam(":employee_id", $this->employee_id);
                  $stmt->bindParam(":toggle_question", $this->toggle_question);
                  $stmt->bindParam(":toggle_answer", $this->toggle_answer);
                  // execute query
                  if($stmt->execute()){
                  return true;
                  }
      
                  return false;
      
      
          }
          public function createEmployee(){

        // query to insert record
                    $query = "INSERT INTO
                    " . $this->table_name . "
                    SET
                    employee_email=:employee_email, employee_fname=:employee_fname
                    , mobile_no=:mobile_no, employee_lname=:employee_lname
                    , postcode=:postcode, mname=:mname, employee_password=:employee_password";

                    // prepare query
                    $stmt = $this->conn->prepare($query);

                    // sanitize
                    $this->employee_email=htmlspecialchars($this->employee_email);
                    $this->employee_fname=htmlspecialchars($this->employee_fname);
                    $this->mobile_no=htmlspecialchars($this->mobile_no);
                    $this->employee_lname=htmlspecialchars($this->employee_lname);
                    $this->postcode=htmlspecialchars($this->postcode);
                    $this->mname=htmlspecialchars($this->mname);
                    $this->employee_password=htmlspecialchars($this->employee_password);

                    // bind values
                    $stmt->bindParam(":employee_email", $this->employee_email);
                    $stmt->bindParam(":employee_fname", $this->employee_fname);
                    $stmt->bindParam(":employee_lname", $this->employee_lname);
                    $stmt->bindParam(":mobile_no", $this->mobile_no);
                    $stmt->bindParam(":postcode", $this->postcode);
                    $stmt->bindParam(":mname", $this->mname);
                    $stmt->bindParam(":employee_password", $this->employee_password);
                    // execute query
                    if($stmt->execute()){
                    return true;
                    }

                    return false;


            }

    // update the employee
            public function updateemployee(){
  
    // update query
    $query = "UPDATE
                " . $this->table_name . "
            SET
            employee_fname = :employee_fname,
            employee_lname = :employee_lname,
            mname = :mname,
            employee_title = :employee_title,
            mobile_no = :mobile_no,
            alt_mobile = :alt_mobile,
            alt_email = :alt_email,
            street_addy = :street_addy,
            city = :city,
            postcode = :postcode,
            updated_acct = :updated_acct,
            country = :country,
            emerg_fname = :emerg_fname,
            emerg_lname = :emerg_lname,
            emerg_relationship = :emerg_relationship,
            emerg_phone = :emerg_phone,
            emerg_address = :emerg_address
            WHERE
            employee_id = :employee_id";
  
    // prepare query statement
    $stmt = $this->conn->prepare($query);
  
    // sanitize
    $this->employee_fname=htmlspecialchars(strip_tags($this->employee_fname));
    $this->employee_title=htmlspecialchars(strip_tags($this->employee_title));
    $this->employee_lname=htmlspecialchars(strip_tags($this->employee_lname));
    $this->mname=htmlspecialchars(strip_tags($this->mname));
    $this->mobile_no=htmlspecialchars(strip_tags($this->mobile_no));
    $this->alt_mobile=htmlspecialchars(strip_tags($this->alt_mobile));
    $this->alt_email=htmlspecialchars(strip_tags($this->alt_email));
    $this->street_addy=htmlspecialchars(strip_tags($this->street_addy));
    $this->city=htmlspecialchars(strip_tags($this->city));
    $this->postcode=htmlspecialchars(strip_tags($this->postcode));
    $this->country=htmlspecialchars(strip_tags($this->country));
    $this->emerg_fname=htmlspecialchars(strip_tags($this->emerg_fname));
    $this->emerg_lname=htmlspecialchars(strip_tags($this->emerg_lname));
    $this->emerg_relationship=htmlspecialchars(strip_tags($this->emerg_relationship));
    $this->emerg_phone=htmlspecialchars(strip_tags($this->emerg_phone));
    $this->emerg_address=htmlspecialchars(strip_tags($this->emerg_address));
  
    // bind new values
    $stmt->bindParam(':employee_id', $this->employee_id);
    $stmt->bindParam(':updated_acct', $this->updated_acct);
    $stmt->bindParam(':employee_title', $this->employee_title);
    $stmt->bindParam(':employee_fname', $this->employee_fname);
    $stmt->bindParam(':employee_lname', $this->employee_lname);
    $stmt->bindParam(':mname', $this->mname);
    $stmt->bindParam(':mobile_no', $this->mobile_no);
    $stmt->bindParam(':alt_mobile', $this->alt_mobile);
    $stmt->bindParam(':alt_email', $this->alt_email);
    $stmt->bindParam(':street_addy', $this->street_addy);
    $stmt->bindParam(':city', $this->city);
    $stmt->bindParam(':postcode', $this->postcode);
    $stmt->bindParam(':country', $this->country);
    $stmt->bindParam(':emerg_fname', $this->emerg_fname);
    $stmt->bindParam(':emerg_lname', $this->emerg_lname);
    $stmt->bindParam(':emerg_relationship', $this->emerg_relationship);
    $stmt->bindParam(':emerg_phone', $this->emerg_phone);
    $stmt->bindParam(':emerg_address', $this->emerg_address);
  
    // execute the query
    if($stmt->execute()){
        return true;
    }
  
    return false;
}
     // update the employee
public function updateonefieldemployee($field_name, $field_value, $employee_id){
  
    // update query
    $query = "UPDATE
                " . $this->table_name . "
            SET
            $field_name = :field_value
            WHERE
            employee_id = :employee_id";
  
    // prepare query statement
    $stmt = $this->conn->prepare($query);
  
    // sanitize
   // $this->$field_name=htmlspecialchars(strip_tags($this->$field_name));
  
    // bind new values
    $stmt->bindParam(':field_value', $field_value);
    $stmt->bindParam(':employee_id', $employee_id);
  
    // execute the query
    if($stmt->execute()){
        return true;
    }
  
    return false;
}   
}
?>