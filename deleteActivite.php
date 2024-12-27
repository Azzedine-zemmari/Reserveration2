<?php
require "./Activite.php";


if (isset($_GET['activite_id'])) {
    $activite_id = $_GET['activite_id']; 

    $activiteClass = new Activite(); 

    if ($activiteClass->delete($activite_id)) {
        header("Location: ./ActiviteDash.php");
        exit();
    } else {
        return "error in the delete function";
        exit();
    }
} else {
    echo "error"; //or page 404
    exit();
}
