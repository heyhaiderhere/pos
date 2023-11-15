<?php
include_once "../connection.php";
echo $_GET['invoiceId'];
if ($result = mysqli_query($databaseConnction, "UPDATE invoices SET payment_status='paid' where invoice_id='" . $_GET["invoiceId"] . "'")) {
    header("location: ../views/unpaidInvoices.php");
} else {
    echo mysqli_error($databaseConnction);
}
