<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}

include 'db.php';

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category = trim($_POST['category_name']);

    if (!empty($category)) {
        $escaped = mysqli_real_escape_string($conn, $category);

        // Check if category already exists
        $check = mysqli_query($conn, "SELECT * FROM categories WHERE name = '$escaped'");
        if (mysqli_num_rows($check) > 0) {
            $message = "⚠️ Category already exists.";
        } else {
            $add = mysqli_query($conn, "INSERT INTO categories (name) VALUES ('$escaped')");
            $message = $add ? "✅ Category added successfully!" : "❌ Failed to add category.";
        }
    } else {
        $message = "⚠️ Please enter a category name.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Category - Try Next Admin</title>
    <link rel="stylesheet" href="add_category.css">

</head>
<body>
    <div class="form-container">
        <h2>➕ Add New Category</h2>
        <form method="POST">
            <label for="category_name">Category Name:</label>
            <input type="text" name="category_name" id="category_name" required>
            <button type="submit">Add Category</button>
        </form>

        <?php if ($message): ?>
            <div class="msg"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>

        <a href="admin_dashboard.php" class="back-link">← Back to Dashboard</a>
    </div>
</body>
</html>
