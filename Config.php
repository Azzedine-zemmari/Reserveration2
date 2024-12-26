<?php 

class connection{

    private $host = "localhost";
    private $dbName = "Rev2";
    private $userName = "root";
    private $userPass = "Azzedine2004";

    public $db;

    public function getConnection(){
        try{
            if(!isset($this->db)){
                $this->db = new PDO("mysql:host=".$this->host.";dbname=".$this->dbName, $this->userName, $this->userPass);
                $this->db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
                return $this->db;
            }
        }
        catch(PDOException $e){
            die("connection failed ".$e->getMessage()); 
        }
    }
}