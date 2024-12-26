<?php

class Connection {

    private $host = "localhost";
    private $dbName = "Rev2";
    private $userName = "root";
    private $userPass = "";

    private $db = null;

    public function getConnection() {
        try {
            // Check if the connection is already established
            if ($this->db === null) {
                $this->db = new PDO(
                    "mysql:host=".$this->host.";dbname=".$this->dbName, 
                    $this->userName, 
                    $this->userPass
                );
                $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
            return $this->db; // Return the database connection

        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    // Optional: A method to close the connection (good practice)
    public function closeConnection() {
        $this->db = null;
    }
}
?>
