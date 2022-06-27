<?php

session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: ../index.php");
}

include '../data/connectDatabase.php';

$user_id_fk = $_SESSION["user_id"];

if(isset($_GET['deleteid'])) {
    $id = $_GET['deleteid'];

    $sql = "DELETE FROM `reservations` WHERE `res_id` = '$id';";
    $result = mysqli_query($conn, $sql);
    if($result) {
        header("Location: ../../admin/modifyReservations.php");
    }else{
        die(mysqli_error($conn));
    }
}

?>