<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}

include 'db.php';

// Fetch all categories
$categoryQuery = mysqli_query($conn, "SELECT * FROM categories ORDER BY name ASC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Categories - Try Next Admin</title>
    <link rel="stylesheet" href="view_category.css">
    <style>
        .category-container {
            max-width: 700px;
            margin: 60px auto;
            padding: 25px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 0 8px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #222;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 12px;
            text-align: center;
        }
        th {
            background-color: #f44336;
            color: white;
        }
        .delete-link {
            color: red;
            font-weight: bold;
            text-decoration: none;
        }
        .delete-link:hover {
            text-decoration: underline;
        }
        .back-btn {
            display: inline-block;
            margin-top: 25px;
            padding: 10px 15px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            text-align: center;
        }
        .back-btn:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>

<div class="category-container">
    <h2>📂 Product Categories</h2>
    <?php if (mysqli_num_rows($categoryQuery) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Category Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php $index = 1; while ($cat = mysqli_fetch_assoc($categoryQuery)): ?>
                <tr>
                    <td><?= $index++ ?></td>
                    <td><?= htmlspecialchars($cat['name']) ?></td>
                    <td>
                        <a href="delete_category.php?id=<?= $cat['id'] ?>" class="delete-link" onclick="return confirm('Delete this category?')">🗑️ Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p style="text-align: center;">No categories found.</p>
    <?php endif; ?>

    <div style="text-align:center;">
        <a href="admin_dashboard.php" class="back-btn">← Back to Dashboard</a>
    </div>
</div>

</body>
</html>