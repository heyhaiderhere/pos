<?php
include_once "../connection.php";
$statement = $db->prepare("DELETE FROM sales where invoice_id=?");
$statement->bind_param("i",  $_GET["invoiceId"]);
$statement->execute();

if ($statement->affected_rows > 0) {
    $invoiceStatement = $db->prepare("DELETE FROM invoices where invoice_id=?");
    $invoiceStatement->bind_param("i",  $_GET["invoiceId"]);
    $invoiceStatement->execute();

    if ($invoiceStatement->affected_rows > 0) {

        header("location: ../views/unpaidInvoices.php");
    } else {
        echo "<h2>No Invoice found</h2>";
    }
    $invoiceStatement->close();
} else {
    echo "<h2>No sales found</h2>";
}

$statement->close();
$db->close();
