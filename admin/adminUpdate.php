<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous" />
    <script src="https://kit.fontawesome.com/fd3e1612ff.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

    <script src="../assets/js/app.js" type="text/javascript" defer></script>
    <script src="../assets/js/setTimeLimitsForUpdate.js" type="text/javascript" defer></script>
    <script src="../assets/sweetAlert/sweetalert2.all.min.js" type="text/javascript" defer></script>

    <link rel="stylesheet" href="../assets/css/app.css" />   
    <link rel="stylesheet" href="../assets/css/update.css">
    <title>Update Reservation</title>
</head>
<body>
    <?php

session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: ../index.php");
}

include '../modules/data/connectDatabase.php';

error_reporting(0);

$user_id_fk = $_SESSION["user_id"];

$id = $_GET['updateid'];

$checkuser = mysqli_query($conn, "SELECT user_id_fk FROM reservations WHERE res_id = '$id';");
$fetchdata = mysqli_fetch_array($checkuser);
$rowuser = $fetchdata['user_id_fk'];

if ($rowuser == NULL) {
    echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Reservation not found!'
            }).then(() => {
                window.location.href = 'modifyReservations.php';
            })
        </script>";
}

if(isset($_POST['updRes'])){
    $resDay = $_POST['resDay'];
    $startTime = $_POST['startTime'];
    $endTime = $_POST['endTime'];

    $courtName = mysqli_query($conn, "SELECT court_name_fk FROM reservations WHERE res_id = '$id';");
    $row = mysqli_fetch_array($courtName);
    $data = $row[0];

    $checkReservationDay = mysqli_query($conn, "SELECT reservation_date FROM `reservations` WHERE reservation_date = '$resDay' and court_name_fk = '$data' and res_id != $id;");
    $timeStart= mysqli_query($conn, "SELECT reservation_start FROM `reservations` WHERE reservation_date = '$resDay' and court_name_fk = '$data' and res_id != $id;");
    $timeEnd = mysqli_query($conn, "SELECT reservation_end FROM `reservations` WHERE reservation_date = '$resDay' and court_name_fk = '$data' and res_id != $id;");

    $checkReservationDayA = mysqli_fetch_all($checkReservationDay);
    $time1 = mysqli_fetch_all($timeStart);
    $time2 = mysqli_fetch_all($timeEnd);

    if ($checkReservationDayA != null) {
        for($j = 0; $j < count($time1); $j++) {
            if ($time1[$j][0] <= $startTime && $time2[$j][0] >= $startTime) {
                $available = false;
                break;
            }elseif ($time1[$j][0] <= $endTime && $time2[$j][0] >= $endTime) {
                $available = false;
                break;
            }elseif ($time1[$j][0] >= $startTime && $time2[$j][0] <= $endTime) {
                $available = false;
                break;
            }else{
                $available = true;
            }
        }

        if($available == false){
        echo '
        <script type="text/javascript">

        Swal.fire({
            title: "Please select another time!",
            text: "Another Reservation already exists at the selected Time!",
            icon: "error"
        });

        </script>
        ';
        }else{
            mysqli_query($conn, "UPDATE `reservations` SET `reservation_date`='$resDay',`reservation_start`='$startTime',`reservation_end`='$endTime' WHERE res_id = '$id';");
            
            echo "
            <script type='text/javascript'>

            Swal.fire({
                title: 'Reservation Updated Successfully!',
                icon: 'success'
            }).then(function() {
                window.location = 'modifyReservations.php';
            });

            </script>
            ";
        }
    }else{
        mysqli_query($conn, "UPDATE `reservations` SET `reservation_date`='$resDay',`reservation_start`='$startTime',`reservation_end`='$endTime' WHERE res_id = '$id';");
        
        echo "
        <script type='text/javascript'>

        Swal.fire({
            title: 'Reservation Updated Successfully!',
            icon: 'success'
        }).then(function() {
            window.location = 'modifyReservations.php';
        });

        </script>
        ";
    }
}

?>
    <div class="main">
        <div class="card">
            <div class="top">
                <h1>You are updating the following reservation</h1>
                <i class="fa-solid fa-arrow-down"></i>
                <div class="display-reservations">
                    <table>
                        <tr>
                            <th>Court</th>
                            <th>Reservation Date</th>
                            <th>Start</th>
                            <th>End</th>
                            </tr>
                    <?php
                        $sql = "SELECT * FROM `reservations` WHERE `res_id` = '$id';";
                        $result = mysqli_query($conn, $sql);
                        while($row = mysqli_fetch_assoc($result)){
                            echo "<tr>";
                            echo "<td>".ucwords($row['court_name_fk'])."</td>";
                            echo "<td>".date('D M j', strtotime($row['reservation_date']))."</td>";
                            echo "<td>".date('h:i a', strtotime($row['reservation_start']))."</td>";
                            echo "<td>".date('h:i a', strtotime($row['reservation_end']))."</td>";
                            echo "</tr>";
                        }
                    ?>
                    </table>
                </div>
                <i class="fa-solid fa-arrow-down"></i>

            </div>
            <form method="post">
                <div class="day-time-selector">
                    <div class="day-selector">
                        <label class="day-label">Select Day</label>
                        <input type="date" name="resDay" id="resDay" required/>
                    </div>
                    <i class="fa-solid fa-arrow-down"></i>
                    <div class="time-selector">
                        <label class="time-label">Select Time</label>
                        <div class="from-to-container">
                        <div class="from-time">
                            <small class="from-to-time-label">From</small>
                            <input type="time" id="startTime" name="startTime" required>
                        </div>
                        <div class="to-time">
                            <small class="from-to-time-label">To</small>
                            <input type="time" id="endTime" name="endTime" required>
                        </div>
                        </div>
                    </div>
                <i class="fa-solid fa-arrow-down"></i>
                <input type="submit" class="btn" value="Update" name="updRes">
                </div>
            </form>
        </div>
    </div>
</body>
</html>