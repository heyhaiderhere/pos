<?php
include_once "../connection.php";
if ($result = mysqli_query($databaseConnction, "SELECT SUM(total_amount) AS today_sales from invoices where payment_status='paid' AND DATE(punch_time) = date('" . $_POST["data"] . "')")) {
    echo  mysqli_fetch_assoc($result)["today_sales"];
} else {
    echo "error";
}
