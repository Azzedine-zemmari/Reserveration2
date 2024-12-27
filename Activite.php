<?php 

require "./Config.php";

class Activite{
    private $conn;
    protected $id;
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

    public function getActivite(){
        $sql = "select * from activite";
        $stmt = $this->conn->prepare($sql);
        if($stmt->execute()){
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        else{
            echo "error in getActivite function";
        }

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
    public function update($id,$titre,$description,$prix,$date_debut,$date_fin,$type,$places_disponibles){
            $this->id = $id;
            $this->titre = $titre;
            $this->description = $description;
            $this->prix = $prix;
            $this->date_debut = $date_debut;
            $this->date_fin = $date_fin;
            $this->type = $type;
            $this->places_disponibles = $places_disponibles;
    
            $sql = "update activite 
            set titre = :titre,
            description = :description,
            prix = :prix,
            date_debut = :date_debut,
            date_fin = :date_fin,
            type = :type,
            places_disponibles = :places_disponibles 
            where idActivite = :id";
    
            $stmt = $this->conn->prepare($sql);

            $stmt->bindParam(":id",$this->id);
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
                $error = $stmt->errorInfo();
                error_log($error[2]);
                return false;
            }
    
    }   


      public function delete($id){
        $sql = "delete from activite where idActivite = :id";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(":id",$id);

        if($stmt->execute()){
            header("Location: ./AcitiviteDash.php");
            return true;
        }
        else{
            return false;
        }
      }
}