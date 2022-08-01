<?php
Class BusinessLogic{
    private $error = array();
    private $randKeyword;
    private $field_ok = false;

    public  function randomPassword() {
        $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
        $pass = array();  
        $alphaLength = strlen($alphabet) - 1; 
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return $this->randKeyword=implode($pass); //
    }
    
    
    public function field_validator($field_descr, $field_data,
        $field_type, $min_length="", $max_length="",
        $field_required=1) {
            

            if(!$field_data && !$field_required){ return; }
            
            # initialize a flag var            
            $email_regexp="^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|";
            $email_regexp.="(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$";
            
            $data_types=array(
                "email"=>$email_regexp,
                "digit"=>"^[0-9]$",
                "number"=>"^[0-9]+$",
                "alpha"=>"^[a-zA-Z]+$",
                "alpha_space"=>"^[a-zA-Z ]+$",
                "alphanumeric"=>"^[a-zA-Z0-9]+$",
                "alphanumeric_space"=>"^[a-zA-Z0-9 ]+$",
                "string"=>""
            );
            
            # check for required fields
            if ($field_required && empty($field_data)) {
                $this->$error[] = "You cannot Login without $field_descr";
                
                
                return;
            }
            if ($field_type == "string") {
                $this->field_ok = true;
            } 
            
            if (!$field_ok) {
                $this->$error[] = "Invalid $field_descr.";
                return;
            }
            
            // field data min length checking:
            if ($field_ok && ($min_length > 0)) {
                if (strlen($field_data) < $min_length) {
                    $this->$error[] = " Invalid $field_descr, it should be at least $min_length character(s).";
                    return;
                }
            }
            
           //  data max length checking:
            if ($field_ok && ($max_length > 0)) {
                if (strlen($field_data) > $max_length) {
                    $this->$error[] = " Invalid $field_descr, it should be less than $max_length characters.";
                    return;
                }
            }
    }
    


}

?>