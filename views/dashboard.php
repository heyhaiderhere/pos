<?php
include_once "../connection.php";
$result = mysqli_query($databaseConnction, "SELECT SUM(total_amount) AS today_sales from invoices where payment_status='paid' AND DATE(punch_time) = CURDATE()");
$sales = mysqli_fetch_assoc($result);

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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Dashboard</title>
</head>

<body>
    <?php include_once "./header.php"; ?>
    <div class="container pt-3">
        <div class="date-picker-container">
            <input style="padding: .5rem;border-radius: 5px;border: none;" class="date-picker" type="date" />
        </div>
        <div class="sales-card">
            <div>
                <i style="font-size: 28px;" class="fa-sharp fa-solid fa-chart-simple"></i>
                <p>Todays Sales</p>
            </div>
            <p class="todays-sales"><?php echo $sales["today_sales"]; ?></p>
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
        if (data === "") {

            $(".todays-sales").text("0")
        } else {
            $(".todays-sales").text(data)

        }
    })
})
</script>

</html>