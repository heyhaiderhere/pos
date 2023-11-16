<?php
include_once "../connection.php";
require('fpdf186/fpdf.php');
session_start();
$count = 55;
$result = mysqli_query($databaseConnction, "SELECT products.product_name, sales.unit_price, sales.sales_id, sales.quantity from sales INNER JOIN products on sales.product_id=products.product_id where sales.invoice_id = '" . $_SESSION['invoice_id'] . "'");
if (mysqli_num_rows($result) > 0) {
    $invoiceData = mysqli_query($databaseConnction, "SELECT * from invoices where invoice_id='" . $_SESSION["invoice_id"] . "'");
    $invoiceDataResult = mysqli_fetch_assoc($invoiceData);
    $pdf = new FPDF("P", "mm", array(80, (130 + (mysqli_num_rows($result) * 5))));
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->SetXY(10, 10);
    $pdf->Cell(0, 10, 'Invoice', 1, 1, "C");
    $pdf->SetY(25);
    $pdf->SetFont('Arial', 'B', 26);
    $pdf->Cell(0, 10, "Cafe King", 0, 1, "C");
    $pdf->SetY(35);
    $pdf->SetX(5);
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(0, 10, "Date: " . $invoiceDataResult["punch_time"], 0, 1, "L");
    $pdf->SetY(40);
    $pdf->SetX(5);
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(0, 10, "Invoice-ID: " . $invoiceDataResult["invoice_id"], 0, 1, "L");
    $pdf->Line(0, 50, 80, 50);
    $pdf->SetXY(5, 50);
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(10, 10, "Name", 0, 1, "L");
    $pdf->SetXY(25, 50);
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(10, 10, "QTY", 0, 1, "L");
    $pdf->SetXY(45, 50);
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(10, 10, "Price", 0, 1, "L");
    $pdf->SetXY(65, 50);
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(10, 10, "Total", 0, 1, "L");
    while ($row = mysqli_fetch_assoc($result)) {
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
    $pdf->SetXY(45, $count + 5);
    $pdf->SetFont('Arial', '', 8);
    $pdf->Cell(10, 10, "SubTotal:", 0, 1, "C");
    $pdf->SetXY(65, $count + 5);
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(10, 10, $invoiceDataResult["total_amount"], 0, 1, "C");
    $pdf->SetFont('Arial', 'B', 20);
    $pdf->Cell(0, 10, $invoiceDataResult["payment_status"], 0, 1, "C");
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, "Made by BitByBit: 03243264180", 0, 1, "C");
    // $pdf->Footer();
    $pdf->Output();
}
// ini_set('display_errors`', 1);
// error_reporting(E_ALL);