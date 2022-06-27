<?php

session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: index.php");
}

include '../modules/data/connectDatabase.php';

$user_id_fk = $_SESSION["user_id"];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;900&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous" />
    <script src="https://kit.fontawesome.com/fd3e1612ff.js" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="../assets/css/app.css">
    <link rel="stylesheet" href="../assets/css/home.css">

    <title>Home</title>
</head>
<body>
    <div id="background">
        <div class="head-container">
            <div class="header">
                <h1>WELCOME TO MEU SPORTS</h1>
            </div>
        </div>
        <div class="main">
            <div class="btn-container">
                <a href="../public/selectCourt.php" class="btn btn-1">RESERVE COURT</a>
                <a href="./modifyReservations.php" class="btn btn-2">MODIFY RESERVATIONS</a>
                <a href="./setAdmin.php" class="btn btn-3">SET ADMIN</a>
            </div>
        </div>
    </div>
</body>
</html>