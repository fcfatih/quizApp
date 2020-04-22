<?php
class Database {

    private $host = "localhost";
    private $db_name = "aydinms";
    private $username = "root";
    private $password = "1234512345";
    public $conn;

    public function getConnection(){
        $this->conn = null;
        try{
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->exec("SET NAMES 'utf8'; SET CHARSET 'utf8'");
        }catch(PDOException $ex){
            echo "Connection error: " . $ex->getMessage();
        }
        return $this->conn;
    }
}
?>