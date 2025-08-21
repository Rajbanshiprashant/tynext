<?php
session_start();

// Prevent caching
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
header("Pragma: no-cache");

// Redirect to login if not logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - Try Next Admin</title>
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>
    <div class="admin-container">
        <h1>Welcome, <?php echo $_SESSION['admin_username']; ?> 👋</h1>
        <div class="admin-links">
            <a href="add_product.php">➕ Add Product</a>
            <a href="view_products.php">📦 View Products</a>
            <a href="add_category.php"> ➕ Add category </a>
            <a href="view_category.php">📂 View Categories</a>
            <a href="manage_orders.php">🛒 Manage Orders</a>
            <a href="logout.php">🚪 Logout</a>
        </div>
    </div>
</body>
</html>
