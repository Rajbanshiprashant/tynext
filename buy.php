<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$conn = mysqli_connect("localhost", "root", "", "trynext");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (!isset($_GET['product_id']) || !isset($_GET['quantity'])) {
    die("Invalid request.");
}

$user_id = $_SESSION['user_id'];
$product_id = intval($_GET['product_id']);
$quantity = intval($_GET['quantity']);

// Fetch product info
$productQuery = mysqli_query($conn, "SELECT * FROM products WHERE id = $product_id");
if (!$productQuery || mysqli_num_rows($productQuery) == 0) {
    die("Product not found.");
}
$product = mysqli_fetch_assoc($productQuery);

// Check if enough stock is available
if ($quantity > $product['stock']) {
    die("Not enough stock available.");
}

$price = $product['price'];
$total_price = $price * $quantity;

// Insert into orders table
$orderInsert = mysqli_query($conn, "
    INSERT INTO orders (user_id, total_amount)
    VALUES ($user_id, $total_price)
");

if (!$orderInsert) {
    die("Error creating order: " . mysqli_error($conn));
}

$order_id = mysqli_insert_id($conn);

// Insert into order_items
$itemInsert = mysqli_query($conn, "
    INSERT INTO order_items (order_id, product_id, quantity, price)
    VALUES ($order_id, $product_id, $quantity, $price)
");

if (!$itemInsert) {
    die("Error adding order item: " . mysqli_error($conn));
}

// Update product stock
$newStock = $product['stock'] - $quantity;
mysqli_query($conn, "UPDATE products SET stock = $newStock WHERE id = $product_id");

echo "<script>alert('✅ Order placed successfully!'); window.location.href='my_orders.php';</script>";
?>
