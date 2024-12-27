<?php 

require "./BannClass.php";


$id = $_GET['user_id'];

$cls = new BannClass();
if($cls->bann($id)){
    header("Location: ./UsersDash.php");
    exit();
}
