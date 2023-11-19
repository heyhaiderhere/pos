<?php
include_once "../connection.php";
$from = $_POST["data"]["from"];
$to = $_POST["data"]["to"];
$statement = $db->prepare("SELECT * from invoices where payment_status='paid' AND DATE(punch_time)  BETWEEN ? AND ?");
$statement->bind_param("ss", $from, $to);
$statement->execute();
$result = $statement->get_result();
if ($result->num_rows > 0) {
    $data = array();
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    header('Content-Type: application/json');
    echo json_encode($data);
} else {
    echo $db->connect_error;
}
