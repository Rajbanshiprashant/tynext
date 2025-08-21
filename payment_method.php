<?php
session_start();
if (!isset($_SESSION['user_id']) || !isset($_GET['product_id']) || !isset($_GET['size']) || !isset($_GET['quantity'])) {
    header("Location: index.php");
    exit();
}

$product_id = intval($_GET['product_id']);
$size = $_GET['size'];
$quantity = intval($_GET['quantity']);
$price= floatval($_GET['product_price']);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Select Payment Method</title>
    <style>
       body {
    font-family: 'Segoe UI', 'Helvetica Neue', Arial, sans-serif;
    padding: 60px;
    text-align: center;
    background-color: #f8f6f4; /* Soft neutral background */
    color: #2c2c2c; /* Deep gray text */
}

h2 {
    margin-bottom: 30px;
    font-size: 28px;
    color: #3a3a3a;
    font-weight: 600;
}

.btn {
    padding: 14px 28px;
    font-size: 17px;
    margin: 12px;
    border: none;
    color: #ffffff;
    background-color: #34495e; /* Deep slate blue */
    cursor: pointer;
    text-decoration: none;
    border-radius: 6px;
    display: inline-block;
    transition: background-color 0.3s ease, transform 0.2s ease;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
}

.btn:hover {
    background-color: #2c3e50; /* Slightly darker slate */
    transform: scale(1.03);
}

    </style>
</head>
<body>

    <h2>Choose a Payment Method</h2>

    <a href="khalti_payment.php?product_id=<?= $product_id ?>&size=<?= urlencode($size) ?>&quantity=<?= $quantity ?>&product_price=<?= $price ?>" class="btn">Pay with Khalti</a>
    <a href="shipping_details.php?product_id=<?= $product_id ?>&size=<?= urlencode($size) ?>&quantity=<?= $quantity ?>&product_price=<?= $price ?>" class="btn">Cash on Delivery</a>

</body>
</html>
