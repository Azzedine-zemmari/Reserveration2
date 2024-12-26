<?php

require_once "./Config.php";
// create an instance of connection 
$Connection = new connection();
// Access the pdo connection
$conn = $Connection->getConnection();
try{
    $query = $conn->query("select * from activite;");
    $activites = $query->fetchAll(PDO::FETCH_ASSOC);
}
catch(PDOException $e){
    echo "query failed" . $e->getMessage();
}
