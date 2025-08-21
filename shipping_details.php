<?php
session_start();
if (!isset($_SESSION['user_id']) || !isset($_GET['product_id']) || !isset($_GET['size']) || !isset($_GET['quantity'])) {
    header("Location: index.php");
    exit();
}

$product_id = intval($_GET['product_id']);
$size = $_GET['size'];
$quantity = intval($_GET['quantity']);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Select Payment Method</title>
    <style>
        body {
    font-family: 'Segoe UI', 'Helvetica Neue', Arial, sans-serif;
    padding: 60px;
    background-color: #f2f0ed; /* Soft warm neutral */
    text-align: center;
    color: #2c2c2c;
}

h2 {
    margin-bottom: 30px;
    font-size: 28px;
    color: #3a3a3a;
    font-weight: 600;
}

/* Primary Button */
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
    background-color: #2c3e50;
    transform: scale(1.03);
}

/* COD Form Container */
.cod-form {
    max-width: 500px;
    margin: 30px auto;
    background-color: #ffffff;
    padding: 30px;
    border-radius: 10px;
    text-align: left;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.06);
}

/* Labels */
.cod-form label {
    display: block;
    margin-bottom: 6px;
    font-weight: 600;
    color: #444;
}

/* Inputs & Textarea */
.cod-form input,
.cod-form textarea {
    width: 100%;
    padding: 12px;
    margin-bottom: 20px;
    border: 1px solid #bfbcb7;
    border-radius: 8px;
    background-color: #fdfdfd;
    font-size: 15px;
    transition: border-color 0.3s ease;
}

.cod-form input:focus,
.cod-form textarea:focus {
    border-color: #7a7a7a;
    outline: none;
}

/* Submit Button */
.cod-form button {
    background-color: #34495e;
    color: #ffffff;
    border: none;
    padding: 12px 20px;
    font-size: 16px;
    border-radius: 8px;
    cursor: pointer;
    transition: background-color 0.3s ease, transform 0.2s ease;
}

.cod-form button:hover {
    background-color: #2c3e50;
    transform: scale(1.02);
}

    </style>
</head>
<body>

    <h2>Shipping Details: </h2>

    <div class="cod-form">
        <form method="POST" action="cash_on_delivery.php">
            <input type="hidden" name="product_id" value="<?= $product_id ?>">
            <input type="hidden" name="size" value="<?= htmlspecialchars($size) ?>">
            <input type="hidden" name="quantity" value="<?= $quantity ?>">

            <label for="full_name">Full Name:</label>
            <input type="text" name="full_name" id="full_name" required>

            <label for="phone">Phone Number:</label>
            <input type="text" name="phone" id="phone" required>

            <label for="address">Delivery Address:</label>
            <textarea name="address" id="address" rows="4" required></textarea>

            <button type="submit">Place Order (Cash on Delivery)</button>
        </form>
    </div>

</body>
</html>
