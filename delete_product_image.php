<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}

include 'db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("❌ Invalid request method.");
}

if (!isset($_POST['image_id']) || !isset($_POST['product_id'])) {
    die("❌ Missing image or product ID.");
}

$image_id = intval($_POST['image_id']);
$product_id = intval($_POST['product_id']);

// Fetch image path
$result = mysqli_query($conn, "SELECT image_path FROM product_images WHERE id = $image_id AND product_id = $product_id");
$image = mysqli_fetch_assoc($result);

if (!$image) {
    die("❌ Image not found.");
}

$image_path = __DIR__ . '/' . $image['image_path'];

// Delete image file from server
if (file_exists($image_path)) {
    unlink($image_path);
}

// Delete image record from database
mysqli_query($conn, "DELETE FROM product_images WHERE id = $image_id AND product_id = $product_id");

// Redirect back to edit page
header("Location: edit_product.php?id=$product_id");
exit();
?>
