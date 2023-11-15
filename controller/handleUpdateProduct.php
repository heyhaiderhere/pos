<?php
include_once "../connection.php";
$productName = $_POST["product_name"];
$costPrice = $_POST["cost_price"];
$sellingPrice = $_POST["selling_price"];
$inStock = $_POST["in_stock"];

echo $sellingPrice;

if (mysqli_query($databaseConnction, "UPDATE products SET product_name='" . $productName . "', cost_price='" . $costPrice . "', selling_price='" . $sellingPrice . "', in_stock='" . $inStock . "' where product_id='" . $_GET["product_id"] . "'")) {
    header("location: ../views/manageProducts.php");
} else {
    echo "hi";
}

// INSERT INTO products (product_name,product_image,cost_price,selling_price,in_stock,category_id,user_id) VALUES ('" . $productName . "', '" . $filePath . "', '" . $costPrice . "', '" . $sellingPrice . "', '" . $inStock . "', 1,1) 