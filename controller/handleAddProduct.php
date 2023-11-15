<?php
include_once "../connection.php";
// mysqli_query($databaseConnction,"");
$productName = $_POST["product_name"];
$costPrice = $_POST["cost_price"];
$sellingPrice = $_POST["selling_price"];
$inStock = $_POST["in_stock"];
// print_r($_FILES["image"]);

if (is_uploaded_file($_FILES["image"]["tmp_name"])) {
    $fileTempName = $_FILES["image"]["tmp_name"];
    $fileName = $_FILES["image"]["name"];
    $filePath = "./assets/images/" . time() . $fileName;
    move_uploaded_file($fileTempName, '.' . $filePath);

    if (mysqli_query($databaseConnction, "INSERT INTO products (product_name,product_image,cost_price,selling_price,in_stock,category_id,user_id) VALUES ('" . $productName . "', '" . $filePath . "', '" . $costPrice . "', '" . $sellingPrice . "', '" . $inStock . "', 1,1)")) {

        header("location: ../views/manageProducts.php");
    }
} else {
    echo "no";
}
