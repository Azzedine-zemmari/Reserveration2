<?php
require "../Config.php" ;


class BannClass{
    private $conn;

    public function __construct()
    {
        $cls = new connection();
        $this->conn = $cls->getConnection();
    }

    public function bann($id){
        $sql = "delete from user where id = :id";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(":id",$id);

        if($stmt->execute()){
            return true;
        }
        else{
            return false;
        }
    }

}