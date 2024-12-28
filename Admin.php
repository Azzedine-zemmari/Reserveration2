<?php
session_start();
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
            $user_id = $this->conn->lastInsertId();

            $_SESSION['user_id'] = $user_id;
            $_SESSION['role'] = 'admin';
            return true;
        }
        else{
            return false;
        }
}
public function loginAdmin($email,$password){
    $this->email = $email;

    $query = "select * from user where email = :email";
    $stmt = $this->conn->prepare($query);   
    
    $stmt->bindParam(':email',$this->email);

    $stmt->execute();

    if($stmt->rowCount() > 0 ){
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user['role'] == 'superAdmin') {
            // Allow plain text password for super admin
            if ($password == $user['password']) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['role'] = 'superAdmin';
                return true;
            }
        } else {
            // Hash verification for regular admins
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['role'] = 'admin';
                return true;
            }
        }
    }
    else{
        return false;
        echo "no user found";
    }
}
}