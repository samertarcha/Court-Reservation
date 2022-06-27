<?php

include 'connectDatabase.php';

ini_set('display_errors','Off');

//Setting time zone, format, variables and arrays
date_default_timezone_set('Asia/Beirut');

$today = date("Y-m-d");

$timeNow = date("H:i:s");

$timeStartF = mysqli_query($conn, "SELECT reservation_start FROM `reservations` WHERE reservation_date = '$today' and court_name_fk = 'football';");
$timeEndF = mysqli_query($conn, "SELECT reservation_end FROM `reservations` WHERE reservation_date = '$today' and court_name_fk = 'football';");

$timeStartB = mysqli_query($conn, "SELECT reservation_start FROM `reservations` WHERE reservation_date = '$today' and court_name_fk = 'basketball';");
$timeEndB = mysqli_query($conn, "SELECT reservation_end FROM `reservations` WHERE reservation_date = '$today' and court_name_fk = 'basketball';");

$timeStartT = mysqli_query($conn, "SELECT reservation_start FROM `reservations` WHERE reservation_date = '$today' and court_name_fk = 'tennis';");
$timeEndT = mysqli_query($conn, "SELECT reservation_end FROM `reservations` WHERE reservation_date = '$today' and court_name_fk = 'tennis';");

$time1F = mysqli_fetch_all($timeStartF);
$time2F = mysqli_fetch_all($timeEndF);

$time1B = mysqli_fetch_all($timeStartB);
$time2B = mysqli_fetch_all($timeEndB);

$time1T = mysqli_fetch_all($timeStartT);
$time2T = mysqli_fetch_all($timeEndT);


//Checking availability of reservation for football
for ($i = 0; $i < count($time1F); $i++) {
    if ($time1F[$i][0] <= $timeNow) {
        if ($time2F[$i][0] >= $timeNow) {
            $checkAvailabilityF = true;
            break;
        }
        else {
            $checkAvailabilityF = false;
    }
    }
    
}

//Checking availability of reservation for basketball
for ($i = 0; $i < count($time1B); $i++) {
    if ($time1B[$i][0] <= $timeNow) {
        if ($time2B[$i][0] >= $timeNow) {
            $checkAvailabilityB = true;
            break;
        }
        else {
            $checkAvailabilityB = false;
    }
    }
    
}

//Checking availability of reservation for tennis
for ($i = 0; $i < count($time1T); $i++) {
    if ($time1T[$i][0] <= $timeNow) {
        if ($time2T[$i][0] >= $timeNow) {
            $checkAvailabilityT = true;
            break;
        }
        else {
            $checkAvailabilityT = false;
    }
    }
    
}

//Updating availability of reservation for football
    if($checkAvailabilityF == true) {
        $updavailF = "UPDATE `courts` SET `availability` = false WHERE `name` = 'football';";
        $resultF = mysqli_query($conn, $updavailF);
    }
    else{
        $updavailF = "UPDATE `courts` SET `availability` = true WHERE `name` = 'football';";
        $resultF = mysqli_query($conn, $updavailF);
    }

//Updating availability of reservation for basketball
    if($checkAvailabilityB == true) {
        $updavailB = "UPDATE `courts` SET `availability` = false WHERE `name` = 'basketball';";
        $resultB = mysqli_query($conn, $updavailB);
    }
    else{
        $updavailB = "UPDATE `courts` SET `availability` = true WHERE `name` = 'basketball';";
        $resultB = mysqli_query($conn, $updavailB);
    }

//Updating availability of reservation for tennis
    if($checkAvailabilityT == true) {
        $updavailT = "UPDATE `courts` SET `availability` = false WHERE `name` = 'tennis';";
        $resultT = mysqli_query($conn, $updavailT);
    }
    else{
        $updavailT = "UPDATE `courts` SET `availability` = true WHERE `name` = 'tennis';";
        $resultT = mysqli_query($conn, $updavailT);
    }
