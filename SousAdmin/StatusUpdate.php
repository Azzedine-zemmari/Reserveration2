<?php
require "../Config.php" ;


class StatusUpdate{
    private $conn;

    public function __construct()
    {
        $cls = new connection();
        $this->conn = $cls->getConnection();
    }

    public function confirm($id){
        $sql = "update reservation set status = 'Confirmee' where id_reservation = :id";
        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(":id",$id);

        if($stmt->execute()){
            return true;
        }
        else{
            return false;
        }
    }

    public function deny($id){
        $sql = "update reservation set status = 'Annulee' where id_reservation = :id";
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