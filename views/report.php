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
        <div style="justify-content: space-between;" class="date-picker-container">
            <input style="padding: .5rem;border-radius: 5px;border: none;" class="date-picker-from" type="date" />
            <p class="fw-bold">To</p>
            <input style="padding: .5rem;border-radius: 5px;border: none;" class="date-picker-to" type="date" />
        </div>
        <div>
            <button class="generate btn btn-dark">Generate</button>
        </div>

        <div>
            <table class="table table-striped mt-4">
                <thead>
                    <tr>
                        <th scope="col">Invoice ID</th>
                        <th scope="col">Order Type</th>
                        <th scope="col">Amount</th>
                        <th scope="col">Order time</th>
                        <!-- <th scope="col">Handle</th> -->
                    </tr>
                </thead>
                <tbody id="tableBody">
                </tbody>
            </table>
        </div>
    </div>
</body>

<script src="../assets/js/jquery.js"></script>

<script>
const datePicker = document.querySelector(".generate");
const fromDate = document.querySelector(".date-picker-from");
const toDate = document.querySelector(".date-picker-to");
datePicker.addEventListener("click", (e) => {
    $.post("../controller/report.php", {
        data: {
            from: fromDate.value,
            to: toDate.value
        }
    }, (data, status) => {
        console.log(data)
        $.each(data, function(index, row) {
            var newRow = '<tr><td>' + row.invoice_id + '</td><td>' + row.order_type +
                '</td><td>' + row
                .total_amount + '</td><td>' + row.punch_time + '</td></tr>';
            $('#tableBody').append(newRow);
        });
    })
})
</script>

</html>