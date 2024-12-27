<?php 

require "./StatusUpdate.php";


$id = $_GET['activite_id'];

$cls = new StatusUpdate();
if($cls->deny($id)){
    header("Location: ./VisualiserReserv.php");
    exit();
}
