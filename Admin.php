<?php

require_once "./Config.php";

class Admins{
    private $conn;

    public function __construct()
    {
        $connection = new connection();
        $this->conn = $connection->getConnection();
    }

    public function getAdmins(){
        try{
            $query = $this->conn->query("SELECT * FROM user where role = 'admin'");
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(PDOException $e){
            echo "query failed successfully ". $e->getMessage();
            return [];
        }
    } 
    public function registerAdmin(){
        
    }
}