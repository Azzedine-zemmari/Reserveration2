<?php 

require "../Config.php";

class Reservation{
    private $conn;
    public function __construct(){
        $cls = new connection();
        $this->conn = $cls->getConnection();
    }


    public function getReservation(){
        $sql = "SELECT reservation.id_reservation, 
                activite.titre, 
                user.nom, 
                reservation.status 
            FROM reservation 
            JOIN user ON user.id = reservation.id_user 
            JOIN activite ON reservation.id_activite = activite.idActivite;";

        $stmt = $this->conn->prepare($sql);

        if($stmt->execute()){
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        else{
            echo "error in the execute";
        }

    }
}