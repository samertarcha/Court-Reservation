<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;900&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous" />
    <script src="https://kit.fontawesome.com/fd3e1612ff.js" crossorigin="anonymous"></script>

    <script src="../assets/js/app.js" defer></script>
    <script src="../assets/js/weatherAPI.js" defer></script>

    <link rel="stylesheet" href="../assets/css/app.css">  
    <link rel="stylesheet" href="../assets/css/main-header.css">
    <link rel="stylesheet" href="../assets/css/setAdmin.css" />
    
    <title>Set Admin</title>
</head>
<body>
<script src="../assets/sweetAlert/sweetalert2.all.min.js"></script>
<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: ../index.php");
}

include '../modules/data/connectDatabase.php';

$user_id_fk = $_SESSION["user_id"];

if(isset($_POST['setUser'])) {
    $fullname = $_POST['setUserAsAdmin'];
    $sql = "UPDATE users SET is_admin = 2 WHERE CONCAT(first_name, ' ', last_name) = '$fullname'";
    $result = mysqli_query($conn, $sql);
    if($result) {
        echo "<script>
                swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'User set as admin!'
                })
            </script>";
    }else{
        echo "<script>
                swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong!'
                })
            </script>";
        die(mysqli_error($conn));
    }
}

if(isset($_POST['unset'])) {
    $fullname = $_POST['unsetUserAsAdmin'];
    $sql = "UPDATE users SET is_admin = 0 WHERE CONCAT(first_name, ' ', last_name) = '$fullname'";
    $result = mysqli_query($conn, $sql);
    if($result) {
        echo "<script>
                swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'User set as normal!'
                })
            </script>";
    }else{
        echo "<script>
                swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong!'
                })
            </script>";
        die(mysqli_error($conn));
    }
} 

?>
    <div id="background">
        <div class="header">
            <div class="header-left">
                <a href="../public/bigCard.php" class="header-navigation-links">RESERVE COURT</a>
                <span class='header-navigation-links-separator'>|</span>
                <a href='modifyReservations.php' class='header-navigation-links'>MODIFY RESERVATIONS</a>
            </div>
            <div  class="toggleHamburgerHidden hidden"></div>
            <a href="tsilaHome.php" class="head-title"><h1>MEU COURT BOOKINGS</h1></a>
            <div id="toggleHamburger"></div>
            <div class="header-right">
                <span class='header-navigation-links-separator hidden'>|</span>
                <a href='modifyReservations.php' class='header-navigation-links hidden'>MOD RESERVATIONS</a>
                <a href="../modules/auth/logout.php" class="notification-logo"><p>LOGOUT</p><i class="fa-solid fa-arrow-right-from-bracket"></i></a>
            </div>
        </div>
        
        <main>
        <div id="dropdown">
            <div class="dropdown-item"><i class="fa-solid fa-house"></i><a href="./tsilaHome.php">HOME</a></div>
            <div class='dropdown-item'><i class='fa-solid fa-calendar-days'></i><a href='../public/bigCard.php'>RESERVE COURT</a></div>
            <div class='dropdown-item'><i class='fa-solid fa-pen'></i><a href='modifyReservations.php'>MODIFY RESERVATIONS</a></div>
            <div class="dropdown-item"><i class="fa-solid fa-arrow-right-from-bracket"></i><a href="../modules/auth/logout.php">LOGOUT</a></div>
        </div>
        
        <div class="weatherParentContainer">
            <div class="weatherContainer">
                <div class="iconContainer"><img class="icon"></img></div>
                <div class="temp"></div>
                <div class="humidity"></div>
                <div class="speed"></div>
            </div>
        </div>
        <div class="main">
            <div class="container">
                <section class="row row-1">
                    <form method='post' action=''>
                        <?php
                            $sql = "SELECT id, first_name, last_name FROM users where is_admin = 0";
                            $result = mysqli_query($conn, $sql);
                            if(mysqli_num_rows($result) == 0){
                                echo "<div class='label'><h2>Set user</h2>";
                                echo "<select name='setUserAsAdmin' id='setUserAsAdmin'>";
                                echo "<option>No users</option>";
                                echo "</select>";
                                echo "<h2>as Admin</h2></div>";
                                echo "<input type='submit' class='btn disabled' Value='Set As Admin' name='setUser'>";
                            }else{
                                echo "<div class='label'><h2>Set user</h2>";
                                echo "<select name='setUserAsAdmin' id='setUserAsAdmin'>";
                                while($row = mysqli_fetch_array($result)){
                                    echo "<option>".$row['first_name']." ".$row['last_name']."</option>";
                                }
                                echo "</select>";
                                echo "<h2>as Admin</h2></div>";
                                echo "<input type='submit' class='btn' Value='Set As Admin' name='setUser'>";
                            }
                        ?>
                    </form>
                </section>
                <section class="row row-2">
                    <form action='' method='post'>
                        <?php
                            $sql = "SELECT id, first_name, last_name FROM users where is_admin = 2";
                            $result = mysqli_query($conn, $sql);
                            if(mysqli_num_rows($result) == 0){
                                echo "<div class='label'><h2>Set user</h2>";
                                echo "<select name='unsetUserAsAdmin' id='unsetUserAsAdmin'>";
                                echo "<option>No users</option>";
                                echo "</select>";
                                echo "<h2>as Normal</h2></div>";
                                echo "<input type='submit' class='btn disabled' Value='Set As Normal' name='unset'>";
                            }else{
                                echo "<div class='label'><h2>Set user</h2>";
                                echo "<select name='unsetUserAsAdmin' id='unsetUserAsAdmin'>";
                                while($row = mysqli_fetch_array($result)){
                                    echo "<option>".$row['first_name']." ".$row['last_name']."</option>";
                                }
                                echo "</select>";
                                echo "<h2>as Normal</h2></div>";
                                echo "<input type='submit' class='btn' Value='Set As Normal' name='unset'>";
                            }
                        ?>
                    </form>
                </section>
            </div>
        </div>
    </div>
</body>
</html>