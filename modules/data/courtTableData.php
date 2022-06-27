<?php

include './connectDatabase.php';

//Getting data from courts table
$getcourts = mysqli_query($conn, "SELECT * FROM courts");

//Storing data in array
$data = array();

while($row = mysqli_fetch_assoc($getcourts)){
    $data[] = $row;
}

//Returning response in JSON format
echo json_encode($data);
exit();