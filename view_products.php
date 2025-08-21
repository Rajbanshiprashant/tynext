<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}

// Prevent back after logout
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");

include 'db.php';

// Fetch each product with its category and main image
$products = mysqli_query($conn, "
    SELECT p.*, c.name AS category_name,
           (
               SELECT image_path FROM product_images
               WHERE product_id = p.id
               ORDER BY id ASC LIMIT 1
           ) AS main_image
    FROM products p
    JOIN categories c ON p.category_id = c.id
    ORDER BY p.created_at DESC
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Products - Try Next Admin</title>
    <link rel="stylesheet" href="view.css">
</head>
<body>
<div class="admin-container">
    <h2>All Products</h2>
    <table>
        <tr>
            <th>Image</th><th>Name</th><th>Category</th><th>Price</th><th>Stock</th><th>Actions</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($products)): ?>
        <tr>
            <td>
                <?php $img = $row['main_image'] ?? 'placeholder.png'; ?>
                <img src="<?= htmlspecialchars($img) ?>" width="70" alt="Product Image">
            </td>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td><?= htmlspecialchars($row['category_name']) ?></td>
            <td>Rs. <?= number_format($row['price'], 2) ?></td>
            <td><?= $row['stock'] ?></td>
            <td>
                <a href="edit_product.php?id=<?= $row['id'] ?>">✏️ Edit</a> |
                <a href="delete_product.php?id=<?= $row['id'] ?>" onclick="return confirm('Are you sure to delete this product?')">🗑️ Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
    <a href="admin_dashboard.php" class="back-btn">Back to Dashboard</a>
</div>
</body>
</html>