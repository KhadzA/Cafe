<?php
// session_start();

if (!isset($_SESSION['user_id']) && $_SESSION['role'] !== 'admin') {
    header("Location: ../../"); 
    exit();
}

else if (!isset($_SESSION['user_id']) && $_SESSION['role'] !== 'cashier') {
    header("Location: ../../"); 
    exit();
}

include 'view/orders.view.php';

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Receipt</title>
    <link rel="icon" href="../../image/Cafe_Logo.png" type="image/icon type">

    <script src="../../js/jquery-3.5.1.min.js"></script>
    <script src="../../js/script.js"></script>
    <script src="../../js/orders.js"></script>
    <!-- <script src="../../resources/bootstrap-5.3.3-dist/js/bootstrap.bundle.js"></script>
    <script src="../../resources/fontawesome-free-6.6.0-web/js/all.js"></script> -->

    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/orders.css">
    <!-- <link rel="stylesheet" href="../../resources/bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../resources/fontawesome-free-6.6.0-web/css/all.css"> -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/js/all.min.js"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

</head>

<body>

    <div class="receipt-container">
        <div class="header">
            <h1>CAFE ALEGRIA</h1>
            <p>Zaragosa Street, ZC, Philippines</p>
            <p>cafealegriya@gmail.com</p>
            <p>Opening Hours: 10am-10pm</p>
        </div>

        <div class="order-info">
            <span>Order no: <?php echo $order['order_id']; ?></span>
            <span>Date: <?php echo $order['order_date']; ?></span>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>Qty</th>
                    <th>Description</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                <!-- Begin PHP loop here -->
                <?php foreach ($order_items as $item): ?>
                    <tr>
                        <td><?php echo $item['quantity']; ?></td>
                        <td><?php echo $item['product_name']; ?> <?php echo $item['size']; ?></td>
                        <td><?php echo number_format($item['amount'], 2); ?></td>
                    </tr>
                <?php endforeach; ?>
                <!-- End PHP loop here -->
            </tbody>
        </table>

        <div class="total">
            Total <strong>₱<?php echo number_format($total_amount, 2); ?></strong>
        </div>
    </div>


</body>

</html>
