<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../assets//bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" href="../assets/css/styles.css" />
    <title>Manage Products</title>
</head>

<body>
    <?php include_once "./header.php"; ?>

    <div class="container py-2">
        <h2 class="display-2">Add new products</h2>
        <form method="post" action="../controller/handleAddProduct.php" enctype="multipart/form-data" class="d-flex flex-column gap-2">
            <input class="form-control form-control-lg" name="product_name" type="text" placeholder="Product name" aria-label="default input example" />
            <input class="form-control form-control-lg" name="cost_price" placeholder="Cost Price" aria-label="default input example" type="number" />
            <input class="form-control form-control-lg" name="selling_price" placeholder="Selling Price" aria-label="default input example" type="number" />
            <input class="form-control form-control-lg" name="in_stock" placeholder="Stock" min="1" aria-label="default input example" type="number" />
            <input class="form-control form-control-lg" name="image" accept="jpeg" type="file" />
            <button type="submit" class="btn w-25 mt-3 btn-dark btn-lg mb-3">
                Add Product
            </button>
        </form>
    </div>
</body>

</html>