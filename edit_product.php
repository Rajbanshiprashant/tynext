<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");

include 'db.php';

if (!isset($_GET['id'])) {
    die("❌ Product ID is missing.");
}

$id = intval($_GET['id']);
$product = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM products WHERE id = $id"));

if (!$product) {
    die("❌ Product not found.");
}

$images = mysqli_query($conn, "SELECT * FROM product_images WHERE product_id = $id");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $desc = mysqli_real_escape_string($conn, $_POST['description']);
    $category_id = $_POST['category_id'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];

    // Update product details
    $query = "UPDATE products SET 
                name = '$name', 
                description = '$desc', 
                category_id = '$category_id', 
                price = '$price', 
                stock = '$stock'
              WHERE id = $id";

    if (mysqli_query($conn, $query)) {
        // Upload new images if provided
        foreach ($_FILES['images']['tmp_name'] as $index => $tmpName) {
            if (!empty($tmpName)) {
                $imageName = basename($_FILES['images']['name'][$index]);
                $imageName = preg_replace("/[^a-zA-Z0-9.\-_]/", "_", $imageName);
                $destination = __DIR__ . '/' . $imageName;

                if (move_uploaded_file($tmpName, $destination)) {
                    mysqli_query($conn, "INSERT INTO product_images (product_id, image_path) VALUES ('$id', '$imageName')");
                }
            }
        }

        header("Location: view_products.php");
        exit();
    } else {
        echo "❌ Error updating product: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Product</title>
    <link rel="stylesheet" href="edit_products.css">
</head>
<body>
<div class="admin-container">
    <h2>Edit Product</h2>
    <form method="POST" enctype="multipart/form-data">
        <input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>" required><br>
        <textarea name="description" required><?= htmlspecialchars($product['description']) ?></textarea><br>
        <select name="category_id" required>
            <option value="1" <?= $product['category_id'] == 1 ? 'selected' : '' ?>>T-Shirt</option>
            <option value="2" <?= $product['category_id'] == 2 ? 'selected' : '' ?>>Hoodie</option>
            <option value="3" <?= $product['category_id'] == 3 ? 'selected' : '' ?>>Jersey</option>
        </select><br>
        <input type="number" name="price" value="<?= $product['price'] ?>" step="0.01" required><br>
        <input type="number" name="stock" value="<?= $product['stock'] ?>" required><br>

        <label>Upload More Images:</label><br>
        <input type="file" name="images[]" multiple><br><br>

        <button type="submit">Update</button>
    </form>

    <h3>Existing Images</h3>
    <?php while ($img = mysqli_fetch_assoc($images)): ?>
        <div style="display:inline-block;margin:10px;text-align:center;">
            <img src="<?= $img['image_path'] ?>" width="80" height="80" style="border:1px solid #ccc;"><br>
            <form method="POST" action="delete_product_image.php" style="margin-top:5px;">
                <input type="hidden" name="image_id" value="<?= $img['id'] ?>">
                <input type="hidden" name="product_id" value="<?= $id ?>">
                <button type="submit" onclick="return confirm('Delete this image?')">🗑️</button>
            </form>
        </div>
    <?php endwhile; ?>
    <a href="admin_dashboard.php" class="back-btn">Back to Dashboard</a>
</div>
</body>
</html>
