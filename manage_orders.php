<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}

include 'db.php';

// Fetch all orders
$orderQuery = mysqli_query($conn, "
    SELECT o.id AS order_id, o.user_id, o.total_amount, o.status, o.order_date, u.name AS user_name
    FROM orders o
    JOIN users u ON o.user_id = u.id
    ORDER BY o.order_date DESC
");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["order_id"], $_POST["new_status"])) {
    $orderId = intval($_POST["order_id"]);
    $newStatus = mysqli_real_escape_string($conn, $_POST["new_status"]);
    
    $update = mysqli_query($conn, "UPDATE orders SET status = '$newStatus' WHERE id = $orderId");

    if ($update) {
        header("Location: manage_orders.php?msg=✅ Order status updated successfully!");
        exit();
    } else {
        header("Location: manage_orders.php?msg=❌ Error updating order status.");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Orders - Try Next Admin</title>
    <link rel="stylesheet" href="manage_orders.css">
    <style>
        .orders-container {
            max-width: 800px;
            margin: 60px auto;
            padding: 30px;
            background: white;
            border-radius: 10px;
            box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        h2 {
            color: #222;
            font-size: 24px;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: #ffffff;
            border-radius: 8px;
            overflow: hidden;
        }
        th, td {
            padding: 14px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f44336;
            color: white;
            font-size: 16px;
        }
        select, button {
            padding: 8px;
            border-radius: 6px;
            font-size: 14px;
            cursor: pointer;
        }
        .status-btn {
            background: #007bff;
            color: white;
            border: none;
            transition: 0.3s ease;
        }
        .status-btn:hover {
            background: #0056b3;
        }
        .back-btn {
            display: inline-block;
            margin-top: 25px;
            padding: 12px 18px;
            background: linear-gradient(90deg, #007bff, #0056b3);
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
            font-size: 16px;
            transition: background 0.3s ease;
        }
        .back-btn:hover {
            background: linear-gradient(90deg, #0056b3, #003f88);
        }
    </style>
</head>
<body>

<div class="orders-container">
    <h2>🛒 Manage Orders</h2>
    <?php if (isset($_GET["msg"])): ?>
        <p style="color: green; font-weight: bold;"><?= htmlspecialchars($_GET["msg"]) ?></p>
    <?php endif; ?>

    <?php if (mysqli_num_rows($orderQuery) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>User</th>
                    <th>Total Amount</th>
                    <th>Status</th>
                    <th>Ordered On</th>
                    <th>Update Status</th>
                </tr>
            </thead>
            <tbody>
            <?php while ($order = mysqli_fetch_assoc($orderQuery)): ?>
                <tr>
                    <td>#<?= $order['order_id'] ?></td>
                    <td><?= htmlspecialchars($order['user_name']) ?></td>
                    <td>Rs. <?= number_format($order['total_amount'], 2) ?></td>
                    <td><?= htmlspecialchars($order['status']) ?></td>
                    <td><?= date("d M Y, h:i A", strtotime($order['order_date'])) ?></td>
                    <td>
                        <?php if ($order['status'] != 'Paid'): ?>
                            <form method="POST" action="">
                                <input type="hidden" name="order_id" value="<?= $order['order_id'] ?>">
                                <select name="new_status">
                                    <option value="Pending">Pending</option>
                                    <option value="Processing">Processing</option>
                                    <option value="Completed">Completed</option>
                                    <option value="Cancelled">Cancelled</option>
                                </select>
                                <button type="submit" class="status-btn">Update</button>
                            </form>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No orders found.</p>
    <?php endif; ?>

    <div style="text-align:center;">
        <a href="admin_dashboard.php" class="back-btn">← Back to Dashboard</a>
    </div>
</div>

</body>
</html>
