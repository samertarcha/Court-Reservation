<?php

session_start();

include '../modules/data/connectDatabase.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: ../index.php");
}

$user_id_fk = $_SESSION["user_id"];

$getUserPrivileges = "SELECT is_admin FROM users WHERE id = '$user_id_fk'";
$result = mysqli_query($conn, $getUserPrivileges);
$row = mysqli_fetch_assoc($result);
$is_admin = $row["is_admin"];

if ($is_admin == 0) {
    $home = 'home.php';
} else if ($is_admin == 1) {
    $home = '../admin/tsilaHome.php';
} else if ($is_admin == 2) {
    $home = '../admin/adminHome.php';
}else  {
    error_log("Error: Unknown user type");
}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />

        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;900&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous" />
        <script src="https://kit.fontawesome.com/fd3e1612ff.js" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

        <script src="../assets/js/app.js" defer></script>
        <script src="../assets/js/weatherAPI.js" defer></script>
        <script src="../assets/js/nextAvailableSlotFootball.js" defer></script>
        <script src="../assets/js/nextAvailableSlotBasketball.js" defer></script>
        <script src="../assets/js/nextAvailableSlotTennis.js" defer></script>
        <script src="../assets/js/courtStatus.js" defer></script>

        <link rel="icon" href="../assets/img/MEU_logo.png">

        <link rel="stylesheet" href="../assets/css/app.css" />
        <link rel="stylesheet" href="../assets/css/main-header.css" />
        <link rel="stylesheet" href="../assets/css/selectCourt.css" />

        <title>SelectCourt</title>
    
    </head>

    <body>
        <div class="header">
            <?php
                if ($is_admin == 1) {
                    echo "<div class='header-left'><a href='../admin/modifyReservations.php' class='header-navigation-links'>MODIFY RESERVATIONS</a><span class='header-navigation-links-separator'>|</span>
                    <a href='../admin/setAdmin.php' class='header-navigation-links padding-right-2em'>SET ADMIN</a></div>";
                } else if ($is_admin == 2) {
                    echo "<div class='header-left'><a href='../admin/modifyReservations.php' class='header-navigation-links'>MODIFY RESERVATIONS</a></div>";
                } else if ($is_admin == 0) {
                    echo "<div class='header-left'><a href='myreservations.php' class='header-navigation-links'>MY RESERVATIONS</a></div>";
                }
            ?>
            <div  class="toggleHamburgerHidden hidden"></div>
            <a href="<?php echo $home ?>" class="head-title"><h1>MEU COURT BOOKINGS</h1></a>
            <div id="toggleHamburger"></div>
            <?php
                if ($is_admin == 1) {
                    echo "<div class='header-right'><a href='../admin/modifyReservations.php' class='header-navigation-links hidden'>MOD RESERVATIONS</a><a href='../modules/auth/logout.php' class='notification-logo'><p>LOGOUT</p><i class='fa-solid fa-arrow-right-from-bracket'></i></a></div>";
                } else if ($is_admin == 2) {
                    echo "<div class='header-right'><a href='../modules/auth/logout.php' class='notification-logo padding-left-5em'><p>LOGOUT</p><i class='fa-solid fa-arrow-right-from-bracket'></i></a></div>";
                } else if ($is_admin == 0) {
                    echo "<div class='header-right'><a href='../modules/auth/logout.php' class='notification-logo'><p>LOGOUT</p><i class='fa-solid fa-arrow-right-from-bracket'></i></a></div>";
                }
            ?>
        </div>
        
        <main>
            <div id="dropdown">
                <div class="dropdown-item"><i class="fa-solid fa-house"></i><a href="<?php echo $home ?>">HOME</a></div>
                <?php 
                    if ($is_admin == 1) {
                        echo "<div class='dropdown-item'><i class='fa-solid fa-pen'></i><a href='../admin/modifyReservations.php'>MODIFY RESERVATIONS</a></div>
                        <div class='dropdown-item'><i class='fa-solid fa-user-pen'></i><a href='../admin/setAdmin.php'>SET ADMIN</a></div>";
                    } else if ($is_admin == 2) {
                        echo "<div class='dropdown-item'><i class='fa-solid fa-pen'></i><a href='../admin/modifyReservations.php'>MODIFY RESERVATIONS</a></div>";
                    } else if ($is_admin == 0) {
                        echo "<div class='dropdown-item'><i class='fa-solid fa-pen'></i><a href='myreservations.php'>MY RESERVATIONS</a></div>";
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
            <div class="court-schedule-parent-container">
                <div class="court-schedule-container">
                    <div class="court-schedule-title">
                        <i class="fa-solid fa-caret-down"></i><h2>Court Schedule</h2><i class="fa-solid fa-caret-down"></i>
                    </div>
                    <div class="court-schedule-content">
                        <div class="court-schedule-item">Monday <i class="fa-solid fa-arrow-right"></i> Thursday | 4 PM <i class="fa-solid fa-arrow-right"></i> 10 PM</div>
                        <div class="court-schedule-item">Friday | 1 PM <i class="fa-solid fa-arrow-right"></i> 4 PM</div>
                        <div class="court-schedule-item">Saturday | 6:30 PM <i class="fa-solid fa-arrow-right"></i> 10:30 PM</div>
                        <div class="court-schedule-item">Sunday | 8 AM <i class="fa-solid fa-arrow-right"></i> 9 PM</div>
                    </div>
                </div>
            </div>
            <div class="parent-container">
                <div class="container" id="container">
                    <div class="card cardF" id="football">
                        <img src="../assets/img/football.jpg"></img>
                        <div class="toggleContent" id="toggleContentF"><i class="fa-solid fa-angles-down"></i></div>
                        <div class="content" id="contentF">
                            <div class="court-info">
                                <div class="info-col">
                                    <div class="label">Status</div>
                                    <div class="availability" id="footballStatus"></div>
                                </div>
                                <div class="info-col">
                                    <div class="label">Next Available Slot</div>
                                    <div class="next-available-slot" id="footballNextAvailableSlot"></div>
                                </div>
                            </div>
                            <a href="bigCard.php#football" class="cta-check-reservation" id="footballRedirectToBigCard">RESERVE COURT</a>
                        </div>
                    </div>
                    <div class="card cardB" id="basketball">
                        <img src="../assets/img/basketball.jpg"></img>
                        <div class="toggleContent" id="toggleContentB"><i class="fa-solid fa-angles-down"></i></div>
                        <div class="content" id="contentB">
                            <div class="court-info">
                                <div class="info-col">
                                    <div class="label">Status</div>
                                    <div class="availability" id="basketballStatus"></div>
                                </div>
                                <div class="info-col">
                                    <div class="label">Next Available Slot</div>
                                    <div class="next-available-slot" id="basketballNextAvailableSlot"></div>
                                </div>
                            </div>
                            <a href="bigCard.php#basketball" class="cta-check-reservation" id="basketballRedirectToBigCard">RESERVE COURT</a>
                        </div>
                    </div>
                    <div class="card cardT" id="tennis">
                        <img src="../assets/img/tennis.jpg"></img>
                        <div class="toggleContent" id="toggleContentT"><i class="fa-solid fa-angles-down"></i></div>
                        <div class="content" id="contentT">
                            <div class="court-info">
                                <div class="info-col">
                                    <div class="label">Status</div>
                                    <div class="availability" id="tennisStatus"></div>
                                </div>
                                <div class="info-col">
                                    <div class="label">Next Available Slot</div>
                                    <div class="next-available-slot" id="tennisNextAvailableSlot"></div>
                                </div>
                            </div>
                            <a href="bigCard.php#tennis" class="cta-check-reservation" id="tennisRedirectToBigCard">RESERVE COURT</a>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </body>
</html>
