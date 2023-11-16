<?php
include_once "./connection.php";
// echo uniqid();
$products = mysqli_query($databaseConnction, "select * from products");
// session_start();
// echo $_SESSION["invoice_id"];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="./assets//bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" href="./assets/css/styles.css" />
    <title>Document</title>
</head>

<body>
    <?php include_once "./views/header.php"; ?>
    <div class="main">

        <div class="products-container">
            <?php
            if (
                mysqli_num_rows($products) >
                0
            ) {
                while ($row = mysqli_fetch_assoc($products)) { ?>
                    <divs class="product-card" data-productId="<?php echo $row["product_id"] ?>" data-in-stock="<?php echo $row["in_stock"] ?>">
                        <div class="product-image-container">
                            <img class="product-image" src="<?php echo $row["product_image"] ?>" alt="<?php echo $row["product_name"] ?>" />
                        </div>
                        <div class="product-details flex">
                            <h4 class="product-name">
                                <?php echo $row["product_name"] ?>
                            </h4>
                            <b>

                                RS:
                                <span class="unit-price">
                                    <?php echo $row["selling_price"] ?>
                                </span>
                            </b>
                        </div>
                    </divs>
            <?php

                }
            }
            ?>
            <a href="./views/addProducts.php" class="product-card add-new">
                <p style="font-size: 80px;">
                    +
                </p>
                <p style="font-size: 24px;">
                    Add New
                </p>

            </a>
        </div>
        <div class="sell-section">
            <div style="justify-self: start;" class="sell-products"></div>
            <div class="sell-billing">
                <div class="form-check w-100 form-switch d-flex align-items-center gap-2 justify-content-around">
                    <input class="form-check-input sell-and-dinning" type="checkbox" role="switch" id="flexSwitchCheckDefault">
                    <label style="font-size: 1.5rem;" class="form-check-label sell-and-dinning-label" for="flexSwitchCheckDefault">Sell</label>
                </div>
                <div class="form-check w-100 form-switch d-flex align-items-center gap-2 justify-content-around">
                    <input class="form-check-input payment-status" type="checkbox" role="switch" id="flexSwitchCheckDefault">
                    <label style="font-size: 1.5rem;" class="form-check-label payment-status-label" for="flexSwitchCheckDefault">unpaid</label>
                </div>
                <div class="billing-data">
                    <p style="font-weight: 500;"> Sub Total</p>
                    <p style="font-weight: 500;" class="sell-sub-total"></p>
                </div>
                <button class="print-bill">Print bill</button>
            </div>
        </div>
    </div>

    <script src="./assets/js/jquery.js"></script>
    <script src="./assets/js/index.js"></script>
    <script>
        $(".print-bill").click(function() {
            if (productSellArray.length === 0) return
            const subTotal = productSellArray.reduce((acc, item) => {
                let subtotal = item.unitPrice * item.quantity;
                return acc + subtotal;
            }, 0);
            $.post("./controller/handleInvoice.php", {
                data: {
                    products: productSellArray,
                    subTotal,
                    orderType: $(".sell-and-dinning-label").text(),
                    paymentStatus: $(".payment-status-label").text(),
                }
            }, function(data, status) {
                console.log(status)
                productSellArray = [];
                billingData.innerText = ""
                sellSection.innerHTML = "";
                renderSellList(productSellArray);
                location.href = "views/invoice.php"

            });

            console.log(productSellArray)
        });
    </script>
</body>

</html>