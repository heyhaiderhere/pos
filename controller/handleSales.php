<?php
include_once "../connection.php";
if ($result = mysqli_query($databaseConnction, "SELECT SUM(total_amount) AS today_sales from invoices where payment_status='paid' AND DATE(punch_time) = date('" . $_POST["data"] . "')")) {
    $profitResults = mysqli_query($databaseConnction, "SELECT SUM(((products.selling_price - products.cost_price)*sales.quantity)) AS profit from sales JOIN products on sales.product_id=products.product_id JOIN invoices ON invoices.invoice_id = sales.invoice_id where invoices.payment_status='paid' AND DATE(invoices.punch_time)=date('" . $_POST["data"] . "');");
    echo json_encode(
        array(
            "profit" => mysqli_fetch_assoc($profitResults)["profit"],
            "todaySales" => mysqli_fetch_assoc($result)["today_sales"]
        ),
    );
} else {
    echo "error";
}
