<?php 

require "./StatusUpdate.php";


$id = $_GET['activite_id'];

$cls = new StatusUpdate();
if($cls->confirm($id)){
    header("Location: ./VisualiserReserv.php");
    exit();
}
