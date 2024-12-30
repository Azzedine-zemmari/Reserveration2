<?php

class Connection {

    private $host = "localhost";
    private $dbName = "Rev2";
    private $userName = "root";
    private $userPass = "Azzedine2004";

    private $db;

    public function getConnection() {
        try {
                $this->db = new PDO(
                    "mysql:host=".$this->host.";dbname=".$this->dbName, 
                    $this->userName, 
                    $this->userPass
                );
                $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
                return $this->db; // Return the database connection

        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

}
?>
