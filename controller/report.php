<?php
include_once "../connection.php";
$from = $_POST["data"]["from"];
$to = $_POST["data"]["to"];
// echo $from;
if ($result = mysqli_query($databaseConnction, "SELECT * from invoices where payment_status='paid' AND DATE(punch_time)  BETWEEN '" . $from . "' AND '" . $to . "'")) {
    $data = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
    header('Content-Type: application/json');
    echo json_encode($data);
} else {
    echo "error";
}
