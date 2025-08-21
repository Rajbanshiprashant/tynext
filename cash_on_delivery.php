<?php
session_start();
if (!isset($_SESSION['user_id']) ||
    !isset($_POST['product_id']) ||
    !isset($_POST['size']) ||
    !isset($_POST['quantity']) ||
    !isset($_POST['full_name']) ||
    !isset($_POST['phone']) ||
    !isset($_POST['address'])) {
    header("Location: index.php");
    exit();
}

$user_id   = $_SESSION['user_id'];
$product_id = intval($_POST['product_id']);
$size       = $_POST['size'];
$quantity   = intval($_POST['quantity']);
$full_name  = trim($_POST['full_name']);
$phone      = trim($_POST['phone']);
$address    = trim($_POST['address']);

$conn = mysqli_connect("localhost", "root", "", "trynext");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check product availability
$productRes = mysqli_query($conn, "SELECT price, stock FROM products WHERE id = $product_id");
$product = mysqli_fetch_assoc($productRes);

if (!$product || $product['stock'] < $quantity) {
    die("❌ Product not found or insufficient stock.");
}

$price = $product['price'];
$total = $price * $quantity;

// Insert order
mysqli_query($conn, "
    INSERT INTO orders (user_id, total_amount, status, payment_status, full_name, phone, shipping_address)
    VALUES ($user_id, $total, 'Pending', 'Cash on Delivery',
        '" . mysqli_real_escape_string($conn, $full_name) . "',
        '" . mysqli_real_escape_string($conn, $phone) . "',
        '" . mysqli_real_escape_string($conn, $address) . "'
    )
");

$order_id = mysqli_insert_id($conn);

// Insert order items
mysqli_query($conn, "
    INSERT INTO order_items (order_id, product_id, quantity, price)
    VALUES ($order_id, $product_id, $quantity, $price)
");

// Reduce stock
mysqli_query($conn, "
    UPDATE products SET stock = stock - $quantity WHERE id = $product_id
");

header("Location: my_orders.php");
exit();
