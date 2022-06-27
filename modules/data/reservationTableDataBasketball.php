<?php

include 'connectDatabase.php';

//Getting data from courts table
$getcourts = mysqli_query($conn, "SELECT TIME_FORMAT(reservation_start, '%H:%i') as reservation_start, TIME_FORMAT(reservation_end, '%H:%i') as reservation_end, reservation_date, court_name_fk FROM reservations WHERE court_name_fk = 'basketball' and CURDATE() < reservation_date or (court_name_fk = 'basketball' and CURDATE() = reservation_date and CURTIME() < reservation_end) ORDER BY reservation_date, reservation_start ASC;");

//Storing data in array
$data = array();

while($row = mysqli_fetch_assoc($getcourts)){
    $data[] = $row;
}

//Returning response in JSON format
echo json_encode($data);
exit();