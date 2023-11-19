<?php
include_once "./connection.php";
$statement = $db->prepare("select * from products");
$statement->execute();
$products = $statement->get_result();
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
    <div style="height: 90vh;">

        <?php include_once "./views/header.php"; ?>
        <div class="main">

            <div class="products-container">
                <?php
                if (
                    mysqli_num_rows($products) >
                    0
                ) {
                    while ($row = $products->fetch_assoc()) { ?>
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
                    <div class="order-type">
                        <div>

                            <input type="radio" name="group1" checked value="sell" onchange="getValueOnChange('group1')">sell
                            <input type="radio" name="group1" value="dinning" onchange="getValueOnChange('group1')">dinning
                            <input type="radio" name="group1" value="delevery" onchange="getValueOnChange('group1')">
                            delevery
                        </div>
                        <div id="selectedValue"></div>
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
            let postData = {
                products: productSellArray,
                subTotal,
                orderType: getSelectedValue("group1"),
                paymentStatus: $(".payment-status-label").text(),
            }
            if (getSelectedValue("group1") === "delevery") {
                postData = {
                    ...postData,
                    deleveryCharges: $(".delevery-charges").val()
                }
            }
            console.log(postData)
            $.post("./controller/handleInvoice.php", {
                data: postData
            }, function(data, status) {
                console.log(status)
                productSellArray = [];
                billingData.innerText = ""
                sellSection.innerHTML = "";
                renderSellList(productSellArray);
                window.open(
                    'http://localhost/pos/views/invoice.php',
                    '_blank'
                );
                location.reload()
            });

        });

        function getValueOnChange(groupName) {
            var radioButtons = document.getElementsByName(groupName);

            for (var i = 0; i < radioButtons.length; i++) {
                if (radioButtons[i].checked) {
                    var selectedValue = radioButtons[i].value;
                    if (selectedValue === "delevery") {
                        const deleveryChargesInput = document.createElement("input");
                        deleveryChargesInput.type = "number";
                        deleveryChargesInput.classList.add("delevery-charges")
                        deleveryChargesInput.placeholder = "Delevery Charges";
                        document.querySelector("#selectedValue").append(deleveryChargesInput);

                    } else {
                        document.querySelector("#selectedValue").innerHTML = ""
                    }
                    return;
                }
            }

        }

        function getSelectedValue(groupName) {
            var radioButtons = document.getElementsByName(groupName);

            for (var i = 0; i < radioButtons.length; i++) {
                if (radioButtons[i].checked) {
                    var selectedValue = radioButtons[i].value;
                    return selectedValue;
                }
            }
        }
    </script>
</body>

</html>