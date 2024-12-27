<?php
require "../Config.php";

class clients{

    private $conn;

    public function __construct()
    {
        $connection = new connection();
        $this->conn = $connection->getConnection();
    }

    public function getClients(){
        $sql = "select * from user where role = 'user'";
        $stmt = $this->conn->prepare($sql);
        if($stmt->execute()){
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        else{
            echo "error in the execute";
        }
    }
}







