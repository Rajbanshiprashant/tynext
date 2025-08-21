<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$conn = mysqli_connect("localhost", "root", "", "trynext");
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

$query = "
    SELECT o.id AS order_id, o.total_amount, o.status, o.order_date, o.payment_status,
           o.shipping_address,
           oi.quantity, oi.price,
           p.name AS product_name,
           (
               SELECT image_path FROM product_images
               WHERE product_id = p.id
               ORDER BY id ASC LIMIT 1
           ) AS main_image
    FROM orders o
    JOIN order_items oi ON o.id = oi.order_id
    JOIN products p ON oi.product_id = p.id
    WHERE o.user_id = $user_id
    ORDER BY o.order_date DESC
";

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Orders - Try Next</title>
    <link rel="stylesheet" href="styles.css">
    <style>
       body {
    font-family: 'Segoe UI', 'Helvetica Neue', Arial, sans-serif;
    padding: 40px;
    background-color: #f2f0ed; /* Soft neutral background */
    color: #2c2c2c;
}

h2 {
    text-align: center;
    margin-bottom: 30px;
    font-size: 26px;
    font-weight: 600;
    color: #3a3a3a;
}

/* Table Styling */
table {
    width: 100%;
    border-collapse: collapse;
    background-color: #ffffff;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.06);
    border-radius: 8px;
    overflow: hidden;
}

/* Table Header */
th {
    background-color: #34495e; /* Deep slate blue */
    color: #ffffff;
    padding: 14px;
    font-size: 16px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Table Cells */
td {
    border-top: 1px solid #e0e0e0;
    padding: 14px;
    text-align: center;
    vertical-align: middle;
    font-size: 15px;
    color: #444;
}

/* Product Thumbnail */
img.product-thumb {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: 6px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.1);
}

/* Status Tags */
.status-Pending {
    color: #e67e22;
    font-weight: 600;
}

.status-Completed {
    color: #27ae60;
    font-weight: 600;
}

.status-Cancelled {
    color: #c0392b;
    font-weight: 600;
}

.status-Cash_on_Delivery {
    color: #16a085;
    font-weight: 600;
}

/* Cancel Link */
a.cancel-link {
    color: #c0392b;
    text-decoration: none;
    font-weight: 600;
    transition: color 0.3s ease, text-decoration 0.3s ease;
}

a.cancel-link:hover {
    text-decoration: underline;
    color: #a93226;
}

    </style>
</head>
<body>

<h2>🧾 My Orders</h2>

<?php if (mysqli_num_rows($result) > 0): ?>
    <table>
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Product</th>
                <th>Image</th>
                <th>Qty</th>
                <th>Unit Price</th>
                <th>Total</th>
                <th>Address</th>
                <th>Status</th>
                <th>Payment</th>
                <th>Ordered On</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <?php $imagePath = $row['main_image'] ?? 'placeholder.png'; ?>
            <tr>
                <td>#<?= $row['order_id'] ?></td>
                <td><?= htmlspecialchars($row['product_name']) ?></td>
                <td><img src="<?= htmlspecialchars($imagePath) ?>" class="product-thumb" alt="Product"></td>
                <td><?= $row['quantity'] ?></td>
                <td>Rs. <?= number_format($row['price'], 2) ?></td>
                <td>Rs. <?= number_format($row['price'] * $row['quantity'], 2) ?></td>
                <td><?= nl2br(htmlspecialchars($row['shipping_address'] ?? '—')) ?></td>
                <td class="status-<?= str_replace(' ', '_', $row['status']) ?>"><?= $row['status'] ?></td>
                <td><?= htmlspecialchars($row['payment_status'] ?? '—') ?></td>
                <td><?= date("d M Y, h:i A", strtotime($row['order_date'])) ?></td>
                <td>
                    <?php if ($row['status'] === 'Pending'): ?>
                        <a href="cancel_order.php?order_id=<?= $row['order_id'] ?>" class="cancel-link" onclick="return confirm('Cancel this order?')">Cancel</a>
                    <?php else: ?>
                        —
                    <?php endif; ?>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
<?php else: ?>
    <p style="text-align: center;">You have not placed any orders yet.</p>
<?php endif; ?>

<div style="text-align: center; margin-top: 30px;">
    <a href="index.php" style="
       background-color: #34495e; /* Deep slate blue */
color: #ffffff;
padding: 12px 24px;
text-decoration: none;
font-weight: 600;
border-radius: 6px;
display: inline-block;
font-size: 16px;
transition: background-color 0.3s ease, transform 0.2s ease;
box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
cursor: pointer;

    ">← Back to Home</a>
</div>

</body>
</html>
