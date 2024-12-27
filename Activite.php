<?php 

require "./Config.php";

class Activite{
    private $conn;
    public $titre;
    public $description;
    public $prix;
    public $date_debut;
    public $date_fin;
    public $type;
    public $places_disponibles;


    public function __construct()
    {
        $conn = new connection();
        $this->conn = $conn->getConnection();
        
    }
    public function addActivite($titre,$description,$prix,$date_debut,$date_fin,$type,$places_disponibles){
        $this->titre = $titre;
        $this->description = $description;
        $this->prix = $prix;
        $this->date_debut = $date_debut;
        $this->date_fin = $date_fin;
        $this->type = $type;
        $this->places_disponibles = $places_disponibles;

        $sql = "insert into activite(titre,description,prix,date_debut,date_fin,type,places_disponibles) values(:titre,:description,:prix,:date_debut,:date_fin,:type,:places_disponibles)";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(":titre",$this->titre);
        $stmt->bindParam(":description",$this->description);
        $stmt->bindParam(":prix",$this->prix);
        $stmt->bindParam(":date_debut",$this->date_debut);
        $stmt->bindParam(":date_fin",$this->date_fin);
        $stmt->bindParam(":type",$this->type);
        $stmt->bindParam(":places_disponibles",$this->places_disponibles);

        if($stmt->execute()){
            return true;
        }
        else{
            return false;
        }

    }


}