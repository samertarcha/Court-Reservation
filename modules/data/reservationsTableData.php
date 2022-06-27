<?php

include 'connectDatabase.php';

//Getting data from courts table
$getreservations = mysqli_query($conn, "SELECT * FROM reservations");

//Storing data in array
$data = array();

while($row = mysqli_fetch_assoc($getreservations)){
    $data[] = $row;
}

//Returning response in JSON format
echo json_encode($data);
exit();