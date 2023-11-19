<?php
include_once "../connection.php";
$statement = $db->prepare("UPDATE invoices SET payment_status='paid' where invoice_id=?");
$statement->bind_param("i",  $_GET["invoiceId"]);
$statement->execute();

if ($statement->affected_rows > 0) {
    header("location: ../views/unpaidInvoices.php");
} else {
    echo "<h2>This invoice is already paid</h2>";
}

$statement->close();
$db->close();
