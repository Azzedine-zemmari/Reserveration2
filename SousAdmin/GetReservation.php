<?php 

require "../Config.php";

class Reservation{
    private $conn;
    public function __construct(){
        $cls = new connection();
        $this->conn = $cls->getConnection();
    }


    public function getReservation(){
        $sql = "select reservation.id_reservation, activite.titre , user.nom , reservation.status from reservation join user on user.id = reservation.id_reservation join activite on reservation.id_activite = activite.idActivite;";

        $stmt = $this->conn->prepare($sql);

        if($stmt->execute()){
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        else{
            echo "error in the execute";
        }

    }
}