<?php

require_once "./Config.php";

class Admins{
    private $conn;
    public $name;
    public $prenom;
    public $email;
    public $password;
    public $role = "admin";

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
    public function registerAdmin($nom,$prenom,$email,$password){
        $this->name = $nom;
        $this->prenom = $prenom;
        $this->email = $email;
        $this->password = password_hash($password, PASSWORD_BCRYPT);
        $query = "insert into user(nom,prenom,email,password,role) values(:nom,:prenom,:email,:password,:role)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':nom',$this->name);
        $stmt->bindParam(":prenom",$this->prenom);
        $stmt->bindParam(':email',$this->email);
        $stmt->bindParam(":password",$this->password);
        $stmt->bindParam(":role",$this->role);

        if($stmt->execute()){
            return true;
        }
        else{
            return false;
        }
}
}