<?php
include_once "../connection.php";
$productName = $_POST["product_name"];
$costPrice = $_POST["cost_price"];
$sellingPrice = $_POST["selling_price"];
$inStock = $_POST["in_stock"];

echo $sellingPrice;
$statement = $db->prepare("UPDATE products SET product_name=?, cost_price=?, selling_price=?, in_stock=? where product_id=?");
$statement->bind_param("siiii", $productName, $costPrice, $sellingPrice, $inStock, $_GET["product_id"]);
if ($statement->execute()) {
    header("location: ../views/manageProducts.php");
} else {
    echo "hi";
}
