<?php
include_once "../connection.php";
$result = mysqli_query($databaseConnction, "SELECT SUM(total_amount) AS today_sales from invoices where payment_status='paid' AND DATE(punch_time) = CURDATE()");
$sales = mysqli_fetch_assoc($result);
$profitResults = mysqli_query($databaseConnction, "SELECT SUM(((products.selling_price - products.cost_price)*sales.quantity)) AS profit from sales JOIN products on sales.product_id=products.product_id JOIN invoices ON invoices.invoice_id = sales.invoice_id where invoices.payment_status='paid' AND DATE(invoices.punch_time)=CURDATE();");
$profit = mysqli_fetch_assoc($profitResults);



// echo "<pre>";
// print_r(mysqli_fetch_assoc($result));
// echo "</pre>";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../assets//bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" href="../assets/css/styles.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Dashboard</title>
</head>

<body>
    <?php include_once "./header.php"; ?>
    <div class="container pt-3">
        <div class="date-picker-container">
            <input style="padding: .5rem;border-radius: 5px;border: none;" class="date-picker" type="date" />
        </div>

        <div class="d-flex gap-3">
            <div class="sales-card">
                <div>
                    <i style="font-size: 28px;" class="fa-sharp fa-solid fa-chart-simple"></i>
                    <p>Todays Sales</p>
                </div>
                <p class="todays-sales"><?php echo $sales["today_sales"]; ?></p>
            </div>
            <div class="sales-card">
                <div>
                    <i style="font-size: 28px;" class="fa-solid fa-dollar-sign"></i>
                    <p>Todays Profit</p>
                </div>
                <p class="todays-profit"> <?php echo $profit["profit"] ?></p>
            </div>
        </div>
    </div>
</body>

<script src="../assets/js/jquery.js"></script>

<script>
    const datePicker = document.querySelector(".date-picker");
    datePicker.addEventListener("change", (e) => {
        $.post("../controller/handleSales.php", {
            data: e.target.value
        }, (data, status) => {
            const dashboardData = JSON.parse(data)

            dashboardData?.profit === null ? $(".todays-profit").text("0") : $(".todays-profit").text(
                dashboardData.profit)
            dashboardData?.todaySales === null ? $(".todays-sales").text("0") : $(".todays-sales").text(
                dashboardData.todaySales)
        })
    })
</script>

</html>