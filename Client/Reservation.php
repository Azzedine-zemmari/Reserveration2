<?php
session_start();
require "../Config.php";
class Reservation{
    public $userId;
    private $conn;
    public function __construct()
    {
        $connection = new connection();
        $this->conn = $connection->getConnection();
    }
    
    public function createReservation($userId,$idActivte){
        $sql = "insert into reservation(id_user,id_activite) values(:id_user,:id_activite)";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(":id_user",$userId);
        $stmt->bindParam(":id_activite",$idActivte);

        if($stmt->execute()){
            return true;
        }
        else{
            return false;
            echo "error in create reservation";
        }
    }
    public function historyReservation($id){

        $sql = "select activite.titre,reservation.* from reservation join activite on activite.idActivite = reservation.id_activite where id_user = :id";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(":id",$id);
        if($stmt->execute()){
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        else{
            return false;
            echo "error in get all reservation";
        }

    }
    public function modifierReservation($id,$Activte){
        // to check if the status is annuler or not
        $checkStatusSQL = "SELECT status FROM reservation WHERE id_reservation = :id";
        $checkStmt = $this->conn->prepare($checkStatusSQL);
        $checkStmt->bindParam(":id", $id);
        $checkStmt->execute();

        // Fetch the status
        $status = $checkStmt->fetchColumn();


        if ($status === 'Annulee') {
            // Status is "Annulée", do not update
            return "Reservation cannot be modified because it is annulée.";
        }
        else{
            $sql = "update reservation set id_Activite = :activite where id_reservation = :id";
    
            $stmt = $this->conn->prepare($sql);
    
            $stmt->bindParam(":id",$id);
            $stmt->bindParam(":activite",$Activte);
    
            if($stmt->execute()){
                return true;
                echo "correct";
            }
            else{
                return false;
            }
        }

    }
}