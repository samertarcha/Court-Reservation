<!DOCTYPE html>
<html lang="en">
    <head>

        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;900&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous" />
        <script src="https://kit.fontawesome.com/fd3e1612ff.js" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

        <script src="../assets/js/app.js" type="text/javascript" defer></script>
        <script src="../assets/js/weatherAPI.js" type="text/javascript" defer></script>
        <script src="../assets/js/setTimeLimits.js" type="text/javascript" defer></script>
        <script src="../assets/js/nextAvailableSlotFootball.js" type="text/javascript" defer></script>
        <script src="../assets/js/nextAvailableSlotBasketball.js" type="text/javascript" defer></script>
        <script src="../assets/js/nextAvailableSlotTennis.js" type="text/javascript" defer></script>
        <script src="../assets/js/courtStatus.js" type="text/javascript" defer></script>

        <link rel="icon" href="../assets/img/MEU_logo.png" />
        
        <link rel="stylesheet" href="../assets/css/app.css" />
        <link rel="stylesheet" href="../assets/css/main-header.css" />
        <link rel="stylesheet" href="../assets/css/big-card.css" />

        <title>Create Reservation</title>

    </head>
    
    <body>
        <script src="../assets/sweetAlert/sweetalert2.all.min.js"></script>
        <?php

        session_start();

        if (!isset($_SESSION["user_id"])) {
            header("Location: ../index.php");
        }

        include '../modules/data/connectDatabase.php';

        include "../modules/data/courtAvailability.php";

        $user_id_fk = $_SESSION["user_id"];

        $getUserPrivileges = "SELECT is_admin FROM users WHERE id = '$user_id_fk'";
        $result = mysqli_query($conn, $getUserPrivileges);
        $row = mysqli_fetch_assoc($result);
        $is_admin = $row["is_admin"];

        if ($is_admin == 0) {
            $home = 'home.php';
            $editReservations = 'myreservations.php';
        } else if ($is_admin == 1) {
            $home = '../admin/tsilaHome.php';
            $editReservations = '../admin/modifyReservations.php';
        } else if ($is_admin == 2) {
            $home = '../admin/adminHome.php';
            $editReservations = '../admin/modifyReservations.php';
        } else  {
            error_log("Error: Unknown user type");
        }

        if (isset($_POST['conf_res_football'])) {

            $footballResDay = $_POST['resDay_f'];
            $footballresStart = $_POST['resStart_f'];
            $footballEndTime = $_POST['endTime_f'];

            $checkReservationDayF = mysqli_query($conn, "SELECT reservation_date FROM `reservations` WHERE reservation_date = '$footballResDay' and court_name_fk = 'football';");
            $timeStartF = mysqli_query($conn, "SELECT time_format(reservation_start,'%H:%i') FROM `reservations` WHERE reservation_date = '$footballResDay' and court_name_fk = 'football';");
            $timeEndF = mysqli_query($conn, "SELECT time_format(reservation_end,'%H:%i') FROM `reservations` WHERE reservation_date = '$footballResDay' and court_name_fk = 'football';");

            $checkReservationDayFA = mysqli_fetch_all($checkReservationDayF);
            $time1F = mysqli_fetch_all($timeStartF);
            $time2F = mysqli_fetch_all($timeEndF);

            if ($checkReservationDayFA != null) {
                for($j = 0; $j < count($time1F); $j++) {
                    if ($time1F[$j][0] < $footballresStart && $time2F[$j][0] > $footballresStart) {
                        $availableF = false;
                        break;
                    } else if ($time1F[$j][0] < $footballEndTime && $time2F[$j][0] > $footballEndTime) {
                        echo '<script type="text/javascript">console.log("2");</script>';
                        $availableF = false;
                        break;
                    } else if ($time1F[$j][0] > $footballresStart && $time2F[$j][0] < $footballEndTime) {
                        echo '<script type="text/javascript">console.log("3");</script>';
                        $availableF = false;
                        break;
                    } else {
                        $availableF = true;
                    }
                }

                if ($availableF == false) {
                    echo '
                    <script type="text/javascript">
                    Swal.fire({
                        title: "Please select another time!",
                        text: "Another Reservation already exists at the selected Time!",
                        icon: "error"
                    });

                    </script>
                    ';
                } else {
                    mysqli_query($conn, "INSERT INTO reservations (reservation_date, reservation_start, reservation_end, user_id_fk, court_name_fk) VALUES ('$_POST[resDay_f]', '$_POST[resStart_f]', '$_POST[endTime_f]', $user_id_fk, 'football');");
                    echo "
                    <script type='text/javascript'>

                    Swal.fire({
                        title: 'Reservation Created Successfully!',
                        icon: 'success'
                    }).then(function() {
                        window.location = '$editReservations';
                    });

                    </script>
                    ";
                }
            } else {
                mysqli_query($conn, "INSERT INTO reservations (reservation_date, reservation_start, reservation_end, user_id_fk, court_name_fk) VALUES ('$_POST[resDay_f]', '$_POST[resStart_f]', '$_POST[endTime_f]', $user_id_fk, 'football');");
                echo "
                <script type='text/javascript'>

                Swal.fire({
                    title: 'Reservation Created Successfully!',
                    icon: 'success'
                }).then(function() {
                    window.location = '$editReservations';
                });

                </script>
                ";
            }
        }


        if(isset($_POST['conf_res_basketball'])) {

            $basketballResDay = $_POST['resDay_b'];
            $basketballresStart = $_POST['resStart_b'];
            $basketballEndTime = $_POST['endTime_b'];

            $checkReservationDayB = mysqli_query($conn, "SELECT reservation_date FROM `reservations` WHERE reservation_date = '$basketballResDay' and court_name_fk = 'basketball';");
            $timeStartB = mysqli_query($conn, "SELECT time_format(reservation_start,'%H:%i') FROM `reservations` WHERE reservation_date = '$basketballResDay' and court_name_fk = 'basketball';");
            $timeEndB = mysqli_query($conn, "SELECT time_format(reservation_end,'%H:%i') FROM `reservations` WHERE reservation_date = '$basketballResDay' and court_name_fk = 'basketball';");

            $checkReservationDayBA = mysqli_fetch_all($checkReservationDayB);
            $time1B = mysqli_fetch_all($timeStartB);
            $time2B = mysqli_fetch_all($timeEndB);

            if ($checkReservationDayBA != null) {
                for($j = 0; $j < count($time1B); $j++) {
                    if ($time1B[$j][0] < $basketballresStart && $time2B[$j][0] > $basketballresStart) {
                        $availableB = false;
                        break;
                    }elseif ($time1B[$j][0] < $basketballEndTime && $time2B[$j][0] > $basketballEndTime) {
                        $availableB = false;
                        break;
                    }elseif ($time1B[$j][0] > $basketballresStart && $time2B[$j][0] < $basketballEndTime) {
                        $availableB = false;
                        break;
                    }else{
                        $availableB = true;
                    }
                }

                if($availableB == false){
                    echo '
                    <script type="text/javascript">
                    console.log("hello");
                    Swal.fire({
                        title: "Please select another time!",
                        text: "Another Reservation already exists at the selected Time!",
                        icon: "error"
                    });

                    </script>
                    ';
                }else{
                    mysqli_query($conn, "INSERT INTO reservations (reservation_date, reservation_start, reservation_end, user_id_fk, court_name_fk) VALUES ('$_POST[resDay_b]', '$_POST[resStart_b]', '$_POST[endTime_b]', $user_id_fk, 'basketball');");
                    echo "
                    <script type='text/javascript'>

                    Swal.fire({
                        title: 'Reservation Created Successfully!',
                        icon: 'success'
                    }).then(function() {
                        window.location = '$editReservations';
                    });

                    </script>
                    ";
                }
            } else {
                mysqli_query($conn, "INSERT INTO reservations (reservation_date, reservation_start, reservation_end, user_id_fk, court_name_fk) VALUES ('$_POST[resDay_b]', '$_POST[resStart_b]', '$_POST[endTime_b]', $user_id_fk, 'basketball');");
                echo "
                <script type='text/javascript'>

                Swal.fire({
                    title: 'Reservation Created Successfully!',
                    icon: 'success'
                }).then(function() {
                    window.location = '$editReservations';
                });

                </script>
                ";
            }
        }


        if(isset($_POST['conf_res_tennis'])) {

            $tennisResDay = $_POST['resDay_t'];
            $tennisresStart = $_POST['resStart_t'];
            $tennisEndTime = $_POST['endTime_t'];

            $checkReservationDayT = mysqli_query($conn, "SELECT reservation_date FROM `reservations` WHERE reservation_date = '$tennisResDay' and court_name_fk = 'tennis';");
            $timeStartT = mysqli_query($conn, "SELECT time_format(reservation_start,'%H:%i') FROM `reservations` WHERE reservation_date = '$tennisResDay' and court_name_fk = 'tennis';");
            $timeEndT = mysqli_query($conn, "SELECT time_format(reservation_end,'%H:%i') FROM `reservations` WHERE reservation_date = '$tennisResDay' and court_name_fk = 'tennis';");

            $checkReservationDayTA = mysqli_fetch_all($checkReservationDayT);
            $time1T = mysqli_fetch_all($timeStartT);
            $time2T = mysqli_fetch_all($timeEndT);

            if ($checkReservationDayTA != null) {
                for($j = 0; $j < count($time1T); $j++) {
                    if ($time1T[$j][0] < $tennisresStart && $time2T[$j][0] > $tennisresStart) {
                        $availableT = false;
                        break;
                    }elseif ($time1T[$j][0] < $tennisEndTime && $time2T[$j][0] > $tennisEndTime) {
                        $availableT = false;
                        break;
                    }elseif ($time1T[$j][0] > $tennisresStart && $time2T[$j][0] < $tennisEndTime) {
                        $availableT = false;
                        break;
                    }else{
                        $availableT = true;
                    }
                    
                }

                if($availableT == false){
                    echo '
                    <script type="text/javascript">
                    console.log("hello");
                    Swal.fire({
                        title: "Please select another time!",
                        text: "Another Reservation already exists at the selected Time!",
                        icon: "error"
                    });

                    </script>
                    ';
                }else {
                    mysqli_query($conn, "INSERT INTO reservations (reservation_date, reservation_start, reservation_end, user_id_fk, court_name_fk) VALUES ('$_POST[resDay_t]', '$_POST[resStart_t]', '$_POST[endTime_t]', $user_id_fk, 'tennis');");
                    echo "
                    <script type='text/javascript'>

                    Swal.fire({
                        title: 'Reservation Created Successfully!',
                        icon: 'success'
                    }).then(function() {
                        window.location = '$editReservations';
                    });

                    </script>
                    ";
                }
            }else{
                mysqli_query($conn, "INSERT INTO reservations (reservation_date, reservation_start, reservation_end, user_id_fk, court_name_fk) VALUES ('$_POST[resDay_t]', '$_POST[resStart_t]', '$_POST[endTime_t]', $user_id_fk, 'tennis');");
                echo "
                <script type='text/javascript'>

                Swal.fire({
                    title: 'Reservation Created Successfully!',
                    icon: 'success'
                }).then(function() {
                    window.location = '$editReservations';
                });

                </script>
                ";
            }
        }

        ?>
        <div class="parent-header-container">
            <div class="header">
                <?php
                    if ($is_admin == 1){
                        echo "<div class='header-left'><a href='../admin/modifyReservations.php' class='header-navigation-links'>MODIFY RESERVATIONS</a><span class='header-navigation-links-separator'>|</span>
                        <a href='../admin/setAdmin.php' class='header-navigation-links padding-right-2em'>SET ADMIN</a></div>";
                    } else if ($is_admin == 2){
                        echo "<div class='header-left'><a href='../admin/modifyReservations.php' class='header-navigation-links'>MODIFY RESERVATIONS</a></div>";
                    } else if ($is_admin == 0){
                        echo "<div class='header-left'><a href='myreservations.php' class='header-navigation-links'>MY RESERVATIONS</a></div>";
                    }
                ?>
                <div  class="toggleHamburgerHidden hidden"></div>
                <a href="<?php echo $home ?>" class="head-title"><h1>MEU COURT BOOKINGS</h1></a>
                <div id="toggleHamburger"></div>
                <?php
                    if ($is_admin == 1){
                        echo "<div class='header-right'><a href='../admin/modifyReservations.php' class='header-navigation-links hidden'>MOD RESERVATIONS</a><a href='../modules/auth/logout.php' class='notification-logo'><p>LOGOUT</p><i class='fa-solid fa-arrow-right-from-bracket'></i></a></div>";
                    } else if ($is_admin == 2){
                        echo "<div class='header-right'><a href='../modules/auth/logout.php' class='notification-logo padding-left-5em'><p>LOGOUT</p><i class='fa-solid fa-arrow-right-from-bracket'></i></a></div>";
                    } else if ($is_admin == 0){
                        echo "<div class='header-right'><a href='../modules/auth/logout.php' class='notification-logo'><p>LOGOUT</p><i class='fa-solid fa-arrow-right-from-bracket'></i></a></div>";
                    }
                ?>
            </div>
            <div class="position-relative-container">
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
            </div>
            <div class="weather-parent-container">
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
        </div>
        <div class="parent-container">
            <div class="container-big-card" id="football">
                <div class="big-card">
                    <form action="" method="post" id="football_form">
                        <div class="scroll-div">
                            <div class="card-title" id="football"><p>Football</p></div>
                            <a class="nav-scroll right basketball" href="#basketball">
                                <p>Basketball</p>
                                <i class="fa-solid fa-arrow-right-long"></i>
                            </a>
                        </div>
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
                        <div class="main-content">
                            <div class="main-left">
                                <div class="main-form">
                                    <div class="day-selector">
                                        <label class="day-label">Select Day</label>
                                            <input type="date" name="resDay_f" id="resDay_f" required/>
                                    </div>
                                    <div class="time-selector">
                                        <label class="time-label">Select Time</label>
                                        <div class="from-to-container">
                                        <div class="from-time">
                                            <small class="from-to-time-label">From</small>
                                            <input type="time" id="resStart_f" name="resStart_f" min="" required>
                                        </div>
                                        <div class="to-time">
                                            <small class="from-to-time-label">To</small>
                                            <input type="time" id="endTime_f" name="endTime_f" max="" required>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="bottom">
                                        <input type="submit" name="conf_res_football" class="btn" value="Confirm Reservation">
                                    </div>
                                </div>
                            </div>
                            <div class="main-right">
                                <div class="table-container">
                                    <table>
                                        <div class="thead">
                                            <tr>
                                                <th>Name</th>
                                                <th>Date</th>
                                                <th>Start</th>
                                                <th>End</th>
                                            </tr>
                                        </div>
                                        <div class="tbody">
                                            <?php
                                                $today = date("Y-m-d");
                                                $sql = "SELECT * FROM reservations INNER JOIN users ON reservations.user_id_fk = users.id WHERE court_name_fk = 'football' and CURDATE() < reservation_date or (court_name_fk = 'football' and CURDATE() = reservation_date and CURTIME() < reservation_end) ORDER BY reservation_date, reservation_start ASC;";
                                                $result = mysqli_query($conn, $sql);
                                                if(mysqli_num_rows($result) == 0){
                                                    echo "<tr>";
                                                    echo "<td colspan = '5'>No reservations</td>";
                                                    echo "</tr>"; 
                                                }else{
                                                    while($row = mysqli_fetch_assoc($result)) {
                                                        echo "<tr>";
                                                        echo "<td>".$row['first_name']. ' ' .$row['last_name']."</td>";
                                                        echo "<td>".date('D M j', strtotime($row['reservation_date']))."</td>";
                                                        echo "<td>".date('h:i a', strtotime($row['reservation_start']))."</td>";
                                                        echo "<td>".date('h:i a', strtotime($row['reservation_end']))."</td>";
                                                        echo "</tr>";
                                                    }
                                                }
                                            ?>
                                        </div>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="container-big-card" id="basketball">
                <div class="big-card">
                    <form action="" method="post">
                        <div class="scroll-div">
                            <a class="nav-scroll left football" href="#football">
                                <i class="fa-solid fa-arrow-left-long"></i>
                                <p>Football</p>
                            </a>
                            <div class="card-title"><p>Basketball</p></div>
                            <a class="nav-scroll right tennis" href="#tennis">
                                <p>Tennis</p>
                                <i class="fa-solid fa-arrow-right-long"></i>
                            </a>
                        </div>
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
                        <div class="main-content">
                            <div class="main-left">
                                <div class="main-form">
                                    <div class="day-selector">
                                        <label class="day-label">Select Day</label>
                                        <input type="date" id="resDay_b" name="resDay_b"/>
                                    </div>
                                    <div class="time-selector">
                                        <label class="time-label">Select Time</label>
                                        <div class="from-to-container">
                                        <div class="from-time">
                                            <small class="from-to-time-label">From</small>
                                            <input type="time" id="resStart_b" name="resStart_b" required>
                                        </div>
                                        <div class="to-time">
                                            <small class="from-to-time-label">To</small>
                                            <input type="time" id="endTime_b" name="endTime_b" required>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="bottom">
                                        <input type="submit" name="conf_res_basketball" class="btn" value="Confirm Reservation">
                                    </div>
                                </div>
                            </div>
                            <div class="main-right">
                                <div class="table-container">
                                    <table>
                                        <div class="thead">
                                            <tr>
                                                <th>Name</th>
                                                <th>Date</th>
                                                <th>Start</th>
                                                <th>End</th>
                                            </tr>
                                        </div>
                                        <div class="tbody">
                                            <?php
                                                $today = date("Y-m-d");
                                                $sql = "SELECT * FROM reservations INNER JOIN users ON reservations.user_id_fk = users.id WHERE court_name_fk = 'basketball' and CURDATE() < reservation_date or (court_name_fk = 'basketball' and CURDATE() = reservation_date and CURTIME() < reservation_end) ORDER BY reservation_date, reservation_start ASC;";
                                                $result = mysqli_query($conn, $sql);
                                                if(mysqli_num_rows($result) == 0){
                                                    echo "<tr>";
                                                    echo "<td colspan = '5'>No reservations</td>";
                                                    echo "</tr>"; 
                                                }else{
                                                    while($row = mysqli_fetch_assoc($result)){
                                                        echo "<tr>";
                                                        echo "<td>".$row['first_name']. ' ' .$row['last_name']."</td>";
                                                        echo "<td>".date('D M j', strtotime($row['reservation_date']))."</td>";
                                                        echo "<td>".date('h:i a', strtotime($row['reservation_start']))."</td>";
                                                        echo "<td>".date('h:i a', strtotime($row['reservation_end']))."</td>";
                                                        echo "</tr>";
                                                    }
                                                }
                                            ?>
                                        </div>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="container-big-card" id="tennis">
                <div class="big-card">
                    <form action="" method="post">
                        <div class="scroll-div">
                            <a class="nav-scroll left basketball" href="#basketball">
                                <i class="fa-solid fa-arrow-left-long"></i>
                                <p>Basketball</p>
                            </a>
                            <div class="card-title" id="tennis"><p>Tennis</p></div>
                        </div>
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
                        <div class="main-content">
                            <div class="main-left">
                                <div class="main-form">
                                    <div class="day-selector">
                                        <label class="day-label">Select Day</label>
                                        <input type="date" id="resDay_t" name="resDay_t"/>
                                    </div>
                                    <div class="time-selector">
                                        <label class="time-label">Select Time</label>
                                        <div class="from-to-container">
                                            <div class="from-time">
                                                <small class="from-to-time-label">From</small>
                                                <input type="time" id="resStart_t" name="resStart_t" min="09:30" max="21:30" required>
                                            </div>
                                            <div class="to-time">
                                                <small class="from-to-time-label">To</small>
                                                <input type="time" id="endTime_t" name="endTime_t" min="09:30" max="21:30" required>
                                            </div>
                                        </div>
                                    </div>     
                                    <div class="bottom">
                                        <input type="submit" name="conf_res_tennis" class="btn" value="Confirm Reservation">
                                    </div>
                                </div>
                            </div>
                            <div class="main-right">
                                <div class="table-container">
                                    <table>
                                        <div class="thead">
                                            <tr>
                                                <th>Name</th>
                                                <th>Date</th>
                                                <th>Start</th>
                                                <th>End</th>
                                            </tr>
                                        </div>
                                        <div class="tbody">
                                            <?php
                                                $today = date("Y-m-d");
                                                $sql = "SELECT * FROM reservations INNER JOIN users ON reservations.user_id_fk = users.id WHERE court_name_fk = 'tennis' and CURDATE() < reservation_date or (court_name_fk = 'tennis' and CURDATE() = reservation_date and CURTIME() < reservation_end) ORDER BY reservation_date, reservation_start ASC;";
                                                $result = mysqli_query($conn, $sql);
                                                if(mysqli_num_rows($result) == 0){
                                                    echo "<tr>";
                                                    echo "<td colspan = '5'>No reservations</td>";
                                                    echo "</tr>"; 
                                                }else{
                                                    while($row = mysqli_fetch_assoc($result)){
                                                        echo "<tr>";
                                                        echo "<td>".$row['first_name']. ' ' .$row['last_name']."</td>";
                                                        echo "<td>".date('D M j', strtotime($row['reservation_date']))."</td>";
                                                        echo "<td>".date('h:i a', strtotime($row['reservation_start']))."</td>";
                                                        echo "<td>".date('h:i a', strtotime($row['reservation_end']))."</td>";
                                                        echo "</tr>";
                                                    }
                                                }
                                            ?>
                                        </div>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>
