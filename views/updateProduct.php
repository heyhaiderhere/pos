<?php
include_once "../connection.php";

$product = $db->prepare("SELECT * FROM products where product_id=?");
$product->bind_param("i", $_GET["product_id"]);
$product->execute();
$row = $product->get_result()->fetch_assoc();
// $row = mysqli_fetch_assoc($product)

// var_dump();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../assets//bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" href="../assets/css/styles.css" />

    <title>Update Product</title>
</head>

<body>
    <?php include_once "./header.php"; ?>

    <div class="container py-2">
        <a href="http://localhost/pos/views/manageProducts.php" class="btn btn-dark">Back</a>
        <h2 class="display-2">Updates this products</h2>
        <form method="post" action="../controller/handleUpdateProduct.php?product_id=<?php echo $row["product_id"] ?>" enctype="multipart/form-data" class="d-flex flex-column gap-2">
            <input class="form-control form-control-lg" value="<?php echo $row["product_name"] ?>" name="product_name" type="text" placeholder="Product name" aria-label="default input example" />
            <input class="form-control form-control-lg" value="<?php echo $row["cost_price"] ?>" name="cost_price" placeholder="Cost Price" aria-label="default input example" type="number" />
            <input class="form-control form-control-lg" value="<?php echo $row["selling_price"] ?>" name="selling_price" placeholder="Selling Price" aria-label="default input example" type="number" />
            <input class="form-control form-control-lg" name="in_stock" value="<?php echo $row["in_stock"] ?>" placeholder="Stock" min="1" aria-label="default input example" type="number" />
            <input class="form-control form-control-lg" name="image" accept="jpeg" type="file" />
            <button type="submit" class="btn w-25 mt-3 btn-dark btn-lg mb-3">
                Update Product
            </button>
        </form>
    </div>
</body>

</html>