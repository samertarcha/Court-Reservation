<?php

session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: ../index.php");
}

include '../modules/data/connectDatabase.php';

$user_id_fk = $_SESSION["user_id"];

$getUserPrivileges = "SELECT is_admin FROM users WHERE id = '$user_id_fk'";
$result = mysqli_query($conn, $getUserPrivileges);
$row = mysqli_fetch_assoc($result);
$is_admin = $row["is_admin"];

if ($is_admin == 0) {
    $home = '../public/home.php';
} else if ($is_admin == 1) {
    $home = 'tsilaHome.php';
} else if ($is_admin == 2) {
    $home = 'adminHome.php';
}else  {
    error_log("Error: Unknown user type");
}

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

    <script src="../assets/js/app.js" defer></script>
    <script src="../assets/js/weatherAPI.js" defer></script>
    <script src="../assets/sweetAlert/sweetalert2.all.min.js" type="text/javascript" defer></script>

    <link rel="stylesheet" href="../assets/css/app.css">
    <link rel="stylesheet" href="../assets/css/main-header.css">
    <link rel="stylesheet" href="../assets/css/myreservations.css" />

    <title>MODIFY RESERVATIONS</title>
</head>

<body>
    <div id="background">
        <div class="header">
            <?php
                if ($is_admin == 1){
                    echo "<div class='header-left'><a href='../public/bigCard.php' class='header-navigation-links'>RESERVE COURT</a><span class='header-navigation-links-separator'>|</span>
                    <a href='setAdmin.php' class='header-navigation-links padding-right-2em'>SET ADMIN</a></div>";
                } else if ($is_admin == 2){
                    echo "<div class='header-left'><a href='../public/bigCard.php' class='header-navigation-links'>RESERVE COURT</a></div>";
                }
            ?>
            <div  class="toggleHamburgerHidden hidden"></div>
            <a href="<?php echo $home ?>" class="head-title"><h1>MEU COURT BOOKINGS</h1></a>
            <div id="toggleHamburger"></div>
            <?php
                if ($is_admin == 1){
                    echo "<div class='header-right'><a href='../public/bigCard.php' class='header-navigation-links hidden'>RESERVATION</a><a href='../modules/auth/logout.php' class='notification-logo'><p>LOGOUT</p><i class='fa-solid fa-arrow-right-from-bracket'></i></a></div>";
                } else if ($is_admin == 2){
                    echo "<div class='header-right'><a href='../modules/auth/logout.php' class='notification-logo'><p>LOGOUT</p><i class='fa-solid fa-arrow-right-from-bracket'></i></a></div>";
                }
            ?>
        </div>
        <main>
            <div id="dropdown">
                <div class="dropdown-item"><i class="fa-solid fa-house"></i><a href="<?php echo $home ?>">HOME</a></div>
                <?php 
                    if ($is_admin == 1) {
                        echo "<div class='dropdown-item'><i class='fa-solid fa-calendar-days'></i><a href='../public/bigCard.php'>RESERVE COURT</a></div>
                        <div class='dropdown-item'><i class='fa-solid fa-user-pen'></i><a href='setAdmin.php'>SET ADMIN</a></div>";
                    } else if ($is_admin == 2) {
                        echo "<div class='dropdown-item'><i class='fa-solid fa-calendar-days'></i><a href='../public/bigCard.php'>RESERVE COURT</a></div>";
                    } 
                ?>
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
            <div class="reservation-table-container">
                <div class="box box-one">
                    <h2>Football</h2>
                    <div class="display-reservations">
                        <table>
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Reservation Date</th>
                                    <th>Start</th>
                                    <th>End</th>
                                    <th>Operation</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $today = date("Y-m-d");
                                    $sql = "SELECT * FROM reservations INNER JOIN users ON reservations.user_id_fk = users.id WHERE court_name_fk = 'football' and CURDATE() < reservation_date or (court_name_fk = 'football' and CURDATE() = reservation_date and CURTIME() < reservation_start) ORDER BY reservation_date, reservation_start ASC;";
                                    $result = mysqli_query($conn, $sql);
                                    if(mysqli_num_rows($result) == 0){
                                        echo "<tr>";
                                        echo "<td colspan = '5'>No reservations</td>";
                                        echo "</tr>"; 
                                    }else{
                                        while($row = mysqli_fetch_array($result)){
                                            echo "<tr>";
                                            echo "<td>".$row['first_name']. ' ' .$row['last_name']."</td>";
                                            echo "<td>".date('D M j', strtotime($row['reservation_date']))."</td>";
                                            echo "<td>".date('h:i a', strtotime($row['reservation_start']))."</td>";
                                            echo "<td>".date('h:i a', strtotime($row['reservation_end']))."</td>";
                                            echo '<td><a href="adminUpdate.php?updateid='.$row['res_id'].'" class="btn update">Edit</a>
                                            <a href="#" class="btn delete" onclick="
                                            adminConfirmDelete('.$row['res_id'].');
                                            ">Cancel</a></td>';
                                            echo "</tr>";
                                        }
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="box box-two">
                    <h2>Basketball</h2>
                    <div class="display-reservations">
                        <table>
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Reservation Date</th>
                                    <th>Start</th>
                                    <th>End</th>
                                    <th>Operation</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $today = date("Y-m-d");
                                    $sql = "SELECT * FROM reservations INNER JOIN users ON reservations.user_id_fk = users.id WHERE court_name_fk = 'basketball' and CURDATE() < reservation_date or (court_name_fk = 'basketball' and CURDATE() = reservation_date and CURTIME() < reservation_start) ORDER BY reservation_date, reservation_start ASC;";
                                    $result = mysqli_query($conn, $sql);
                                    if(mysqli_num_rows($result) == 0){
                                        echo "<tr>";
                                        echo "<td colspan = '5'>No reservations</td>";
                                        echo "</tr>"; 
                                    }else{
                                        while($row = mysqli_fetch_array($result)){
                                            echo "<tr>";
                                            echo "<td>".$row['first_name']. ' ' .$row['last_name']."</td>";
                                            echo "<td>".date('D M j', strtotime($row['reservation_date']))."</td>";
                                            echo "<td>".date('h:i a', strtotime($row['reservation_start']))."</td>";
                                            echo "<td>".date('h:i a', strtotime($row['reservation_end']))."</td>";
                                            echo '<td><a href="adminUpdate.php?updateid='.$row['res_id'].'" class="btn update">Edit</a>
                                            <a href="#" class="btn delete" onclick="
                                            adminConfirmDelete('.$row['res_id'].');
                                            ">Cancel</a></td>';
                                            echo "</tr>";
                                        }
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="box box-three">
                    <h2>Tennis</h2>
                    <div class="display-reservations">
                        <table>
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Reservation Date</th>
                                    <th>Start</th>
                                    <th>End</th>
                                    <th>Operation</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $today = date("Y-m-d");
                                    $sql = "SELECT * FROM reservations INNER JOIN users ON reservations.user_id_fk = users.id WHERE court_name_fk = 'tennis' and CURDATE() < reservation_date or (court_name_fk = 'tennis' and CURDATE() = reservation_date and CURTIME() < reservation_start) ORDER BY reservation_date, reservation_start ASC;";
                                    $result = mysqli_query($conn, $sql);
                                    if(mysqli_num_rows($result) == 0){
                                        echo "<tr>";
                                        echo "<td colspan = '5'>No reservations</td>";
                                        echo "</tr>"; 
                                    }else{
                                        while($row = mysqli_fetch_array($result)){
                                            echo "<tr>";
                                            echo "<td>".$row['first_name']. ' ' .$row['last_name']."</td>";
                                            echo "<td>".date('D M j', strtotime($row['reservation_date']))."</td>";
                                            echo "<td>".date('h:i a', strtotime($row['reservation_start']))."</td>";
                                            echo "<td>".date('h:i a', strtotime($row['reservation_end']))."</td>";
                                            echo '<td><a href="adminUpdate.php?updateid='.$row['res_id'].'" class="btn update">Edit</a>
                                            <a href="#" class="btn delete" onclick="
                                            adminConfirmDelete('.$row['res_id'].');
                                            ">Cancel</a></td>';
                                            echo "</tr>";
                                        }
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>

</html>