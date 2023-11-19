<?php
include_once "../connection.php";
$invoice = $_POST["data"]["products"];
$paymentStatus = $_POST["data"]["paymentStatus"];
$orderType = $_POST["data"]["orderType"];


if (mysqli_query($db, "INSERT INTO invoices (order_type, payment_status, total_amount) VALUES('" . $orderType . "','" . $paymentStatus . "', '" . $_POST['data']['subTotal'] . "')")) {
    session_start();
    $invoiceId = mysqli_insert_id($db);
    $_SESSION["invoice_id"] = $invoiceId;
    if (isset($_POST["data"]["deleveryCharges"])) {
        $_SESSION["delevery_charges"] = $_POST["data"]["deleveryCharges"];
    } else {
        unset($_SESSION["delevery_charges"]);
    }
    foreach ($invoice as $product) {
        if (mysqli_query($db, "INSERT INTO sales (product_id,invoice_id,quantity,unit_price,sub_total) VALUES ('" . $product["productId"] . "','" . $invoiceId . "', '" . $product["quantity"] . "', '" . $product["unitPrice"] . "', '" . $product["unitPrice"] * $product["quantity"] . "')")) {
            mysqli_query($db, "UPDATE products SET in_stock=(in_stock-'" . $product["quantity"] . "') where product_id='" . $product["productId"] . "'");
        } else {
            echo mysqli_error($db);
        }
    }
} else {
    echo mysqli_error($db);
}
