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

   
}