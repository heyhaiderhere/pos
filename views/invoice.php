<?php
include_once "../connection.php";
require('fpdf186/fpdf.php');
session_start();
$count = 60;
$statement = $db->prepare("SELECT products.product_name, sales.unit_price, sales.sales_id, sales.quantity, invoices.order_type from sales INNER JOIN products on sales.product_id=products.product_id JOIN invoices ON sales.invoice_id=invoices.invoice_id where sales.invoice_id =?");
$statement->bind_param("i", $_SESSION["invoice_id"]);
$statement->execute();

// echo $_SESSION["delevery_charges"];

$result = $statement->get_result();
if ($result->num_rows > 0) {
    $invoiceData = mysqli_query($db, "SELECT * from invoices where invoice_id='" . $_SESSION["invoice_id"] . "'");
    $invoiceDataResult = mysqli_fetch_assoc($invoiceData);
    $pdf = new FPDF("P", "mm", array(80, (130 + ($result->num_rows * 5)) + $count));
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->SetXY(10, 10);
    $pdf->Cell(0, 10, 'Invoice', 1, 1, "C");
    $pdf->SetY(25);
    $pdf->SetFont('Arial', 'B', 26);
    $pdf->Cell(0, 10, "Cafe King", 0, 1, "C");
    $pdf->SetY(35);
    $pdf->SetX(5);
    $pdf->SetFont('Arial', 'b', 10);
    $pdf->Cell(0, 10, "Date: " . $invoiceDataResult["punch_time"], 0, 1, "L");
    $pdf->SetY(40);
    $pdf->SetX(5);
    $pdf->SetFont('Arial', 'b', 10);
    $pdf->Cell(0, 10, "Invoice-ID: " . $invoiceDataResult["invoice_id"], 0, 1, "L");
    $pdf->SetY(45);
    $pdf->SetX(5);
    $pdf->SetFont('Arial', 'b', 10);
    $pdf->Cell(0, 10, "Order Type: " . $invoiceDataResult["order_type"], 0, 1, "L");
    $pdf->Line(0, 55, 80, 55);
    $pdf->SetXY(5, 55);
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(10, 10, "Name", 0, 1, "L");
    $pdf->SetXY(25, 55);
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(10, 10, "QTY", 0, 1, "L");
    $pdf->SetXY(45, 55);
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(10, 10, "Price", 0, 1, "L");
    $pdf->SetXY(65, 55);
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(10, 10, "Total", 0, 1, "L");
    while ($row = $result->fetch_assoc()) {
        // echo  $count;
        $pdf->SetXY(0, $count);
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(100, 10, $row["product_name"], 0, 1, "L");
        $pdf->SetXY(25, $count);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(10, 10, $row["quantity"], 0, 1, "C");
        $pdf->SetXY(45, $count);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(10, 10, $row["unit_price"], 0, 1, "C");
        $pdf->SetXY(65, $count);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(10, 10, $row["unit_price"] * $row["quantity"], 0, 1, "C");
        $count = $count + 5;
    }
    $pdf->Line(0, $count + 5, 80, $count + 5);
    if (isset($_SESSION["delevery_charges"])) {
        $pdf->SetXY(45, $count + 5);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(10, 10, "Delevery Charges:", 0, 1, "R");
        $pdf->SetXY(65, $count + 5);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(10, 10, $_SESSION["delevery_charges"], 0, 1, "C");
    }
    $pdf->SetXY(45, $count + 10);
    $pdf->SetFont('Arial', '', 8);
    $pdf->Cell(10, 10, "SubTotal:", 0, 1, "R");
    $pdf->SetXY(65, $count + 10);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(10, 10, $invoiceDataResult["total_amount"] + $_SESSION["delevery_charges"], 0, 1, "C");
    $pdf->SetFont('Arial', 'B', 20);
    $pdf->Cell(0, 20, $invoiceDataResult["payment_status"], 0, 1, "C");
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, "Cafe King: 03243264180", 0, 1, "C");
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, "Software by BitByBit: 03243264180", 0, 1, "C");
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, ".", 0, 1, "C");
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, ".", 0, 1, "C");
    // $pdf->Footer();
    $pdf->Output();
}
// unset($_SESSION["delevery_charges"]);
// ini_set('display_errors`', 1);
// error_reporting(E_ALL);