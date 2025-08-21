<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "trynext");

// Fetch categories dynamically
$categoryMap = [];
$categoryQuery = mysqli_query($conn, "SELECT * FROM categories");

while ($cat = mysqli_fetch_assoc($categoryQuery)) {
    $categoryMap[strtolower($cat['name'])] = $cat['id'];
}

// Get selected category from URL
$selectedCategory = null;
$categoryName = "";
if (isset($_GET['category']) && array_key_exists($_GET['category'], $categoryMap)) {
    $selectedCategory = $categoryMap[$_GET['category']];
    $categoryName = ucfirst($_GET['category']);
}

$user_logged_in = isset($_SESSION['user']);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Try Next - Home</title>
    <link rel="stylesheet" href="styles.css">
    
</head>
<body>

<header>
    <div class="logo-container">
        <a href="index.php" style="display: flex; align-items: center; text-decoration: none; color: inherit;">
            <img src="trynext.jpg" alt="Try Next Logo" class="logo">
            <h1>Try Next</h1>
        </a>
    </div>

    <nav>
        <a href="my_orders.php" class="orders-link">🛒 Orders</a> <!-- Orders now centered -->
        <div class="user-controls">
            <?php if (isset($_SESSION['user_name'])): ?>
                <span style="color: #fdb95e; font-weight: bold;">Hi! <?= htmlspecialchars($_SESSION['user_name']) ?></span>
                <a href="logout.php">Logout</a>
            <?php else: ?>
                <a href="login.php">Login</a>
                <a href="signup.php">Sign Up</a>
            <?php endif; ?>
        </div>
    </nav>
</header>


<section class="banner">
    <h2>Unisex Streetwear</h2>
    <p>Explore T-Shirts, Hoodies & Jerseys</p>
</section>

<section class="categories">
    <div class="category-list">
        <?php
        mysqli_data_seek($categoryQuery, 0); // Reset query pointer
        while ($cat = mysqli_fetch_assoc($categoryQuery)): ?>
            <a href="index.php?category=<?= strtolower($cat['name']) ?>" class="category-item">
                <h3><?= htmlspecialchars($cat['name']) ?></h3>
            </a>
        <?php endwhile; ?>
    </div>
</section>

<?php if ($selectedCategory): ?>
    <section class="products">
        <h2><?= htmlspecialchars($categoryName) ?> Collection</h2>
        <div class="product-list">
            <?php
            $query = "SELECT * FROM products WHERE category_id = $selectedCategory";
            $result = mysqli_query($conn, $query);

            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $product_id = $row['id'];
                    $img_query = mysqli_query($conn, "SELECT image_path FROM product_images WHERE product_id = $product_id LIMIT 1");
                    $image = ($img_query && mysqli_num_rows($img_query) > 0)
                        ? mysqli_fetch_assoc($img_query)['image_path']
                        : 'default.png';

                    echo '<div class="product">';
                    echo '<a href="product_details.php?product_id=' . $product_id . '">';
                    echo '<img src="' . htmlspecialchars($image) . '" alt="' . htmlspecialchars($row['name']) . '">';
                    echo '</a>';
                    echo '<h3>' . htmlspecialchars($row['name']) . '</h3>';
                    echo '<p>Rs. ' . htmlspecialchars($row['price']) . '</p>';
                    echo '<a href="product_details.php?product_id=' . $product_id . '" class="buy-btn">Buy Now</a>';
                    echo '</div>';
                }
            } else {
                echo "<p>No products available.</p>";
            }
            ?>
        </div>
    </section>
<?php endif; ?>

<footer>
    <p>&copy; <?= date("Y") ?> Try Next Clothing Brand</p>
</footer>

</body>
</html>
