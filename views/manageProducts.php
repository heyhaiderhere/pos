<?php
include_once "../connection.php";
$statement =  $db->prepare("select * from products");
$statement->execute();
$products = $statement->get_result();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" href="../assets/css/styles.css" />
    <title>Document</title>
</head>

<body>
    <?php include_once "./header.php"; ?>

    <div class="container mt-4">
        <a href="http://localhost/pos/" class="btn btn-dark">Back</a>
        <table class="table table-striped">
            <thead class="table-light">
                <tr>
                    <th scope="col">Product Id</th>
                    <th scope="col">Product Name</th>
                    <th scope="col">image</th>
                    <th scope="col">Cost Price</th>
                    <th scope="col">Selling Price</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Edit</th>
                    <th scope="col">delete</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = $products->fetch_assoc()) {
                ?>

                    <tr class="manage-products-row">
                        <th><?php echo $row["product_id"] ?></th>
                        <td><?php echo $row["product_name"] ?></td>
                        <td><img height="60" src="<?php echo "." . $row["product_image"] ?>" /></td>
                        <td><?php echo $row["cost_price"] ?></td>
                        <td><?php echo $row["selling_price"] ?></td>
                        <td><?php echo $row["in_stock"] ?></td>
                        <td><a style="font-size: 40px; text-decoration:none;" href="./updateProduct.php?product_id=<?php echo $row["product_id"] ?>">&#128394</a></td>
                        <td><a style="font-size: 40px; text-decoration:none;" href="../controller/deleteProduct.php?product_id=<?php echo $row["product_id"] ?>">
                                &#128465;</a></td>
                    </tr>

                <?php
                }
                ?>
            </tbody>
        </table>
    </div>


    <script src="../assets/js/jquery.js"></script>
    <script>
        $(".manage-products-row").click(function(e) {

        });
    </script>
</body>

</html>