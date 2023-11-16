<?php
include_once "../connection.php";

$results = mysqli_query($databaseConnction, "SELECT * FROM invoices where payment_status ='unpaid'");

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../assets//bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" href="../assets/css/styles.css" />
    <title>Unpaid Invoices</title>
</head>


<body>
    <?php include_once "./header.php"; ?>

    <div class="container">

        <h2 class='display-2'>Unpaid invoices</h2>
        <a href="http://localhost/pos/" class="mb-2 btn btn-dark">Back</a>
        <div class="main-unpaid-wrapper">
            <?php
            if (mysqli_num_rows($results) > 0) {
                while ($row = mysqli_fetch_assoc($results)) {
            ?>
                    <div class="unpaid-invoice-card">
                        <p>Invoice No: <span class="fw-bold"> <?php echo $row["invoice_id"]; ?></span></php>
                        <p>Order Type:<span class="fw-bold"> <?php echo $row["order_type"]; ?></span></php>
                        <p>Payment Status: <span class="fw-bold"> <?php echo $row["payment_status"]; ?></span></php>
                        <p>Amount:<span class="fw-bold"> <?php echo $row["total_amount"]; ?></span></php>
                        <form action="../controller/handlePayUnpaidInvoices.php?invoiceId=<?php echo $row["invoice_id"]; ?>" method="post">
                            <button class="btn btn-dark mt-2" type="submit">Pay this Invoice</button>
                        </form>
                    </div>
            <?php
                }
            } else {
                echo "<h2 class='display-2'>No more Unpaid invoices</h2>";
            }
            ?>
        </div>
    </div>
</body>

</html>