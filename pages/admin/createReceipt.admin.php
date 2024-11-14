<?php
// session_start();

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
    <!-- <script src="../../js/script.js"></script> -->
    <script src="../../js/orders.js"></script>
    <script src="../../resources/bootstrap-5.3.3-dist/js/bootstrap.bundle.js"></script>
    <script src="../../resources/fontawesome-free-6.6.0-web/js/all.js"></script>

    <!-- <link rel="stylesheet" href="../../css/style.css"> -->
    <link rel="stylesheet" href="../../css/orders.css">
    <link rel="stylesheet" href="../../resources/bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../resources/fontawesome-free-6.6.0-web/css/all.css">

    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/js/all.min.js"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"> -->

</head>

<body>                      <!-- Change the body to this if that necessary came:      <body onload="window.print();"> -->

    <!-- Remove this thing if necessary -->
    <script>
        window.onload = function() {
            window.print();  // Trigger the print dialog when the page loads
            window.onafterprint = function() {
                window.close();  
            };
        };
    </script>

    

    <div class="receipt-container"> 
        <div class="header">
            <h1>CAFE ALEGRIA</h1>
            <!-- Other header information -->
        </div>
        
        <div class="order-info">
            <span>Order no: <?php echo htmlspecialchars($order_id); ?></span>
            <span>Date: <?php echo htmlspecialchars($order['order_date']); ?></span>
        </div>

        <!-- Table for order items -->
        <table class="table">
            <thead>
                <tr>
                    <th>Qty</th>
                    <th>Description</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($order_items as $item): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                        <td>
                            <?php echo htmlspecialchars($item['product_name']); ?><br>
                            <?php echo htmlspecialchars(($item['size'] ?? '') . " " . ($item['sugar_level'] ?? '')); ?>
                        </td>
                        <td>₱<?php echo number_format($item['amount'], 2); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="total">
            <strong>Total: ₱<?php echo number_format($order['total_amount'], 2); ?></strong>
        </div>

        <div class="payment-info">
            <p>Cash Given: ₱<?php echo number_format($cash_given, 2); ?></p>
            <p>Change: ₱<?php echo number_format($change, 2); ?></p>
        </div>
    </div>
</body>

</html>
