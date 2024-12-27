<?php

require "../Config.php";

class clientAuth{
    private $conn;
    public $nom;
    public $prenom;
    public $email;
    public $password;
    public $role = 'user';

    public function __construct()
    {
        $connection = new connection();
        $this->conn = $connection->getConnection();
    }

    public function registerClient($nom,$prenom,$email,$password){
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->email = $email;
        $this->password = password_hash($password,PASSWORD_BCRYPT);

        $sql = "insert into user(nom,prenom,email,password) values(:nom,:prenom,:email,:password)";
        $stmt = $this->conn->prepare($sql);
        

        $stmt->bindParam(":nom",$this->nom);
        $stmt->bindParam(":prenom",$this->prenom);
        $stmt->bindParam(":email",$this->email);
        $stmt->bindParam(":password",$this->password);

        if($stmt->execute()){
            return true;
        }
        else{
            return false;
        }
}
public function loginClient($email,$password){
    $this->email = $email;

    $sql = "select * from user where email = :email";

    $stmt = $this->conn->prepare($sql);

    $stmt->bindParam(":email",$this->email);

    $stmt->execute();

    if($stmt->rowCount() > 0){
        $USER = $stmt->fetch(PDO::FETCH_ASSOC);

        if(password_verify($password,$USER['password'])){
            return true;
        }
        else{
            echo "invalid password";
        }

    }
    else{
        echo "this email not found";
    }
}

}