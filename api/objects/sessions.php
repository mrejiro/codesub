<?php
class sessions{
    public $employee_logged_id;
    public $employee_id;
    private $log_in_status = false;

    
  public function createsession($var, $employee_id) {
    if(!isset($_SESSION)) 
    { 
    session_start();
    }
    if (!isset($_SESSION['employee_logged_id'])) {
        $this->log_in_status = true;
        $logged_cookie = $_SESSION['employee_logged_id'] = $this->employee_logged_id = $var;
        $logged_cookie_employee_id = $_SESSION['employee_logged_employee_id'] = $this->employee_id = $employee_id;
        header("Location: ".ACCESS_ROOT);
        $cookie_name = "loggedin_user";
        $cookie_value = $logged_cookie;
        setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/");

    }

 /*    $this->class_id = isset($_SESSION['class_id']) ? $_SESSION['class_id'] : null;
    $this->email = isset($_SESSION['email']) ? $_SESSION['email'] : null;
    $this->fname = isset($_SESSION['fname']) ? $_SESSION['fname'] : null; */
    }
   
    public function unset_created($var){
        if (isset($_SESSION['employee_logged_id'])) {
            $this->log_in_status = false;
            unset($_SESSION["employee_logged_id"]);
            if (isset($_COOKIE['loggedin_user'])) {
                unset($_COOKIE['loggedin_user']); 
                setcookie('loggedin_user', null, -1, '/'); 
                return true;
            }
           
        }
    }
    public function redirect(){
        if (!isset($_SESSION['employee_logged_id'])) {
            $this->log_in_status = false;
            header("Location: ".INDEX_ROOT);
        }
    } 
    public function profile_redirect(){
        if (isset($_SESSION['employee_logged_id'])) {
            $this->log_in_status = false;
            header("Location: ".PROFILE_ROOT);
        }
    }
 }
    $session = new sessions();
