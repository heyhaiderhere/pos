<?php
include_once "../connection.php";
echo $_GET["product_id"];
if (mysqli_query($databaseConnction, "DELETE FROM products where product_id='" . $_GET["product_id"] . "'")) {
    header("location: ../views/manageProducts.php");
} else {
    echo "something wentWrong";
}
