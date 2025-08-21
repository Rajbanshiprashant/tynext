<?php
// start session
$conn = mysqli_connect("localhost", "root", "", "trynext");
session_start();
//purchase_order_id=17 extract this from $_GET
$purchase_order_id = $_GET['purchase_order_id'];
 $user_id = $_SESSION['user_id'];

$conn = mysqli_connect("localhost", "root", "", "trynext");
// get product_id from session
$product_id = $_SESSION['product_id'];
// get total price from session
$total_price = $_SESSION['total_price'];
// get quantity from session
$quantity = $_SESSION['quantity'];

 // Save Payment in Database
    $sql = "INSERT INTO payment (user_id, amount, method, status) VALUES ('$user_id', '$total_price', 'Khalti', 'Paid')";
    $result = mysqli_query($conn, $sql);
// update orders table form purchase_order_id to set status to Paid
mysqli_query($conn, "
    UPDATE orders SET status = 'Paid' WHERE id = $purchase_order_id
");

echo("Payment successful!");
// print quantity and product_id
echo("Quantity: " . $quantity);
echo("Product ID: " . $product_id);

// Reduce stock
mysqli_query($conn, "
    UPDATE products SET stock = stock - $quantity WHERE id = $product_id
");

header("Location: my_orders.php");
// exit();