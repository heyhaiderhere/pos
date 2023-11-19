<?php
include_once "../connection.php";
$salesStatement = $db->prepare("SELECT SUM(total_amount) AS today_sales from invoices where payment_status='paid' AND DATE(punch_time) = date(?)");
$salesStatement->bind_param("s", $_POST["data"]);
$salesStatement->execute();
$result =  $salesStatement->get_result();
if ($result->num_rows > 0) {
    $profitStatement = $db->prepare("SELECT SUM(((products.selling_price - products.cost_price)*sales.quantity)) AS profit from sales JOIN products on sales.product_id=products.product_id JOIN invoices ON invoices.invoice_id = sales.invoice_id where invoices.payment_status='paid' AND DATE(invoices.punch_time)=date(?);");
    $profitStatement->bind_param("s", $_POST["data"]);
    $profitStatement->execute();
    $profitResults = $profitStatement->get_result();
    echo json_encode(
        array(
            "profit" => $profitResults->fetch_assoc()["profit"],
            "todaySales" => $result->fetch_assoc()["today_sales"]
        ),
    );
} else {
    echo "error";
}
