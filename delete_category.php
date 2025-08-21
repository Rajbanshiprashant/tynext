<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}

include 'db.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $category_id = intval($_GET['id']);

    // Check if the category exists
    $check = mysqli_query($conn, "SELECT * FROM categories WHERE id = $category_id");
    if (mysqli_num_rows($check) > 0) {
        
        // Delete category
        $delete = mysqli_query($conn, "DELETE FROM categories WHERE id = $category_id");

        if ($delete) {
            header("Location: view_category.php?msg=Category deleted successfully!");
            exit();
        } else {
            header("Location: view_category.php?msg=❌ Error deleting category.");
            exit();
        }
    } else {
        header("Location: view_category.php?msg=⚠️ Category not found.");
        exit();
    }
} else {
    header("Location: view_category.php?msg=❌ Invalid request.");
    exit();
}
?>
