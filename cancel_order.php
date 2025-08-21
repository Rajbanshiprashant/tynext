<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if (!isset($_GET['order_id']) || !is_numeric($_GET['order_id'])) {
    die("❌ Invalid order ID.");
}

$order_id = intval($_GET['order_id']);

$conn = mysqli_connect("localhost", "root", "", "trynext");
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Check if this order belongs to the user and is still pending
$checkQuery = "
    SELECT * FROM orders 
    WHERE id = $order_id AND user_id = $user_id AND status = 'Pending'
    LIMIT 1
";
$result = mysqli_query($conn, $checkQuery);

if (!$result || mysqli_num_rows($result) === 0) {
    die("❌ Cannot cancel this order. It may not exist, belong to you, or already be processed.");
}

// Cancel the order
$cancelQuery = "
    UPDATE orders 
    SET status = 'Cancelled' 
    WHERE id = $order_id
";
if (mysqli_query($conn, $cancelQuery)) {
    header("Location: my_orders.php?msg=cancelled");
    exit();
} else {
    echo "❌ Error canceling order: " . mysqli_error($conn);
}
?>
