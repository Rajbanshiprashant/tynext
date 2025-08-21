<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}

include 'db.php';

if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // Delete images from folder
    $images = mysqli_query($conn, "SELECT image_path FROM product_images WHERE product_id = '$product_id'");
    while ($row = mysqli_fetch_assoc($images)) {
        $file = __DIR__ . '/' . $row['image_path'];
        if (file_exists($file)) {
            unlink($file);
        }
    }

    // Delete from product_images
    mysqli_query($conn, "DELETE FROM product_images WHERE product_id = '$product_id'");

    // Delete from product_sizes
    mysqli_query($conn, "DELETE FROM product_sizes WHERE product_id = '$product_id'");

    // Delete from products
    mysqli_query($conn, "DELETE FROM products WHERE id = '$product_id'");

    header("Location: view_products.php");
    exit();
} else {
    echo "❌ Invalid Product ID";
}
?>
