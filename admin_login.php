<?php
session_start();
include 'db.php';

// Redirect if already logged in
$isLoggedIn = isset($_SESSION['admin_logged_in']);
$adminUsername = $isLoggedIn ? htmlspecialchars($_SESSION['admin_username']) : '';

if ($isLoggedIn) {
    header("Location: admin_dashboard.php");
    exit();
}

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';

    if (!empty($username) && !empty($password)) {
        $username = mysqli_real_escape_string($conn, $username);
        $password = mysqli_real_escape_string($conn, $password);

        $query = "SELECT * FROM admins WHERE username = '$username' AND password = '$password'";
        $result = mysqli_query($conn, $query);

        if ($result && mysqli_num_rows($result) === 1) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_username'] = $username;
            header("Location: admin_dashboard.php");
            exit();
        } else {
            $error = "❌ Invalid username or password.";
        }
    } else {
        $error = "❌ Please fill in both fields.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Login - Try Next</title>
    <link rel="stylesheet" href="admin_log.css">
</head>
<body>
    <div class="admin-container">
        <h2>Admin Login</h2>
        <?php if ($error) echo "<p class='error'>$error</p>"; ?>
        <form method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
