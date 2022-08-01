<?php
define('API_NAMESPACE', 'Sambrowne Foods');
define('API_DIR_ROOT',   dirname(__FILE__));
define('API_DIR_CLASSES', API_DIR_ROOT . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR);



class Database{
  
    private $host = "localhost";
    private $db_name = "company_info";
    private $username = "root";
    private $password = "";
    public  $conn;
  
    // get the db connection
    public function getConnection(){
  
        $this->conn = null;
  
        try{
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        }catch(PDOException $exception){
            echo "Connection erto database error: " . $exception->getMessage();
        }
  
        return $this->conn;
    }
}
?>