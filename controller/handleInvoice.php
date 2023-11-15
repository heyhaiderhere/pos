<?php
include_once "../connection.php";
$invoice = $_POST["data"]["products"];
$paymentStatus = $_POST["data"]["paymentStatus"];
$orderType = $_POST["data"]["orderType"];
if (mysqli_query($databaseConnction, "INSERT INTO invoices (order_type, payment_status, total_amount) VALUES('" . $orderType . "','" . $paymentStatus . "', '" . $_POST['data']['subTotal'] . "')")) {
    session_start();
    $invoiceId = mysqli_insert_id($databaseConnction);
    $_SESSION["invoice_id"] = $invoiceId;
    foreach ($invoice as $product) {
        if (mysqli_query($databaseConnction, "INSERT INTO sales (product_id,invoice_id,quantity,unit_price,sub_total) VALUES ('" . $product["productId"] . "','" . $invoiceId . "', '" . $product["quantity"] . "', '" . $product["unitPrice"] . "', '" . $product["unitPrice"] * $product["quantity"] . "')")) {
            mysqli_query($databaseConnction, "UPDATE products SET in_stock=(in_stock-'" . $product["quantity"] . "') where product_id='" . $product["productId"] . "'");
        } else {
            echo mysqli_error($databaseConnction);
        }
    }
} else {
    echo mysqli_error($databaseConnction);
}
