<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}

include 'db.php';

$msg = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $desc = mysqli_real_escape_string($conn, $_POST['description']);
    $category_id = $_POST['category_id'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $sizes = $_POST['sizes'];
    $created_at = date('Y-m-d H:i:s');

    // Insert product data
    $query = "INSERT INTO products (name, description, category_id, price, stock, created_at)
              VALUES ('$name', '$desc', '$category_id', '$price', '$stock', '$created_at')";
    if (mysqli_query($conn, $query)) {
        $product_id = mysqli_insert_id($conn);

        // Insert sizes
        $sizeArray = explode(',', $sizes);
        foreach ($sizeArray as $size) {
            $size = trim($size);
            if (!empty($size)) {
                mysqli_query($conn, "INSERT INTO product_sizes (product_id, size) VALUES ('$product_id', '$size')");
            }
        }

        // Upload and save multiple images
        if (!empty($_FILES['images']['name'][0])) {
            foreach ($_FILES['images']['tmp_name'] as $index => $tmpName) {
                if ($_FILES['images']['error'][$index] === UPLOAD_ERR_OK) {
                    $imageName = basename($_FILES['images']['name'][$index]);
                    $imageName = preg_replace("/[^a-zA-Z0-9.\-_]/", "_", $imageName); // sanitize
                    $destination = __DIR__ . '/' . $imageName;

                    if (move_uploaded_file($tmpName, $destination)) {
                        mysqli_query($conn, "INSERT INTO product_images (product_id, image_path) VALUES ('$product_id', '$imageName')");
                    }
                }
            }
        }

        $msg = "✅ Product added successfully!";
    } else {
        $msg = "❌ Failed to add product: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Product - Try Next Admin</title>
    <link rel="stylesheet" href="add_p.css">
</head>
<body>
<div class="admin-container">
    <h2>Add New Product</h2>
    <?php if ($msg) echo "<p class='info'>$msg</p>"; ?>

    <form action="add_product.php" method="POST" enctype="multipart/form-data">
        <label>Name:</label>
        <input type="text" name="name" required><br>

        <label>Description:</label>
        <textarea name="description" required></textarea><br>

        <label>Category:</label>
        <select name="category_id" required>
            <option value="1">T-Shirt</option>
            <option value="2">Hoodie</option>
            <option value="3">Jersey</option>
        </select><br>

        <label>Price:</label>
        <input type="number" name="price" required><br>

        <label>Stock:</label>
        <input type="number" name="stock" required><br>

        <label>Sizes (comma separated):</label>
        <input type="text" name="sizes" placeholder="S, M, L, XL" required><br>

        <label>Product Images:</label>
        <input type="file" name="images[]" multiple required><br>

        <button type="submit">Add Product</button>
    </form>

    <a href="admin_dashboard.php" class="back-btn">Back to Dashboard</a>
</div>
</body>
</html>
