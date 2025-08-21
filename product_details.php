<?php
session_start();

// Redirect to login if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// DB Connection
$conn = mysqli_connect("localhost", "root", "", "trynext");
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Validate product_id
if (!isset($_GET['product_id']) || !is_numeric($_GET['product_id'])) {
    die("❌ Invalid product.");
}
$product_id = intval($_GET['product_id']);

// Fetch product details
$productQuery = mysqli_query($conn, "SELECT * FROM products WHERE id = $product_id");
if (!$productQuery || mysqli_num_rows($productQuery) === 0) {
    die("❌ Product not found.");
}
$product = mysqli_fetch_assoc($productQuery);

// Fetch images and define main image
$imageQuery = mysqli_query($conn, "SELECT * FROM product_images WHERE product_id = $product_id");
$mainImage = "placeholder.png";
$allImages = [];

if ($imageQuery && mysqli_num_rows($imageQuery) > 0) {
    while ($row = mysqli_fetch_assoc($imageQuery)) {
        $allImages[] = $row['image_path'];
    }
    $mainImage = $allImages[0];
}

// Fetch sizes
$sizeQuery = mysqli_query($conn, "SELECT * FROM product_sizes WHERE product_id = $product_id");
if (!$sizeQuery) {
    die("❌ Error fetching sizes: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html>
<head>
    <title><?= htmlspecialchars($product['name']) ?> - Try Next</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .product-detail-container {
    display: flex;
    flex-wrap: wrap;
    max-width: 1000px;
    margin: 40px auto;
    padding: 30px;
    gap: 40px;
    background-color: #f4f1ee; /* Soft ivory */
    border-radius: 12px;
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
}

/* Image Gallery */
.image-gallery {
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
}

.main-image {
    width: 320px;
    height: auto;
    border-radius: 10px;
    border: 1px solid #d6d3ce;
    margin-bottom: 20px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    background-color: #ffffff;
}

.thumbnail-container {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
    justify-content: center;
}

.thumbnail {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: 6px;
    border: 1px solid #bfbcb7;
    cursor: pointer;
    transition: transform 0.2s ease, border-color 0.3s ease;
    background-color: #fff;
}

.thumbnail:hover {
    transform: scale(1.05);
    border-color: #6c757d;
}

/* Product Info */
.product-info {
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: center;
    color: #2c2c2c;
}

.product-info h2 {
    font-size: 26px;
    margin-bottom: 15px;
    color: #3a3a3a;
}

.product-info p {
    font-size: 16px;
    color: #5f5f5f;
    margin-bottom: 20px;
}

.product-info form {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.product-info select,
.product-info input[type="number"] {
    padding: 10px;
    font-size: 16px;
    border: 1px solid #bfbcb7;
    border-radius: 8px;
    background-color: #fdfdfd;
    transition: border-color 0.3s ease;
}

.product-info select:focus,
.product-info input[type="number"]:focus {
    border-color: #7a7a7a;
    outline: none;
}

/* Button */
.product-info button {
    background-color: #2f2f2f; /* Deep charcoal */
    color: #ffffff;
    padding: 12px;
    font-size: 16px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.product-info button:hover {
    background-color: #444444;
}

    </style>
    <script>
        function swapImage(src) {
            document.getElementById('mainImage').src = src;
        }
    </script>
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
        <?php if (isset($_SESSION['user_name'])): ?>
            <span style="color: #fdb95e; font-weight: bold;">Hi! <?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
            <a href="logout.php">Logout</a>
        <?php else: ?>
            <a href="login.php">Login</a>
            <a href="signup.php">Sign Up</a>
        <?php endif; ?>
    </nav>
</header>

<div class="product-detail-container">
    <div class="image-gallery">
        <img id="mainImage" src="<?= htmlspecialchars($mainImage) ?>" alt="Main Image" class="main-image">
        <div class="thumbnail-container">
            <?php foreach ($allImages as $imgPath): ?>
                <img class="thumbnail" src="<?= htmlspecialchars($imgPath) ?>" onclick="swapImage(this.src)">
            <?php endforeach; ?>
        </div>
    </div>

    <div class="product-info">
        <h2><?= htmlspecialchars($product['name']) ?></h2>
        <p><?= nl2br(htmlspecialchars($product['description'])) ?></p>
        <p><strong>Rs. <?= number_format($product['price'], 2) ?></strong></p>

        <form class="product-info-form" action="payment_method.php" method="GET">
            <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
            <input type="hidden" name="product_price" value="<?= $product['price'] ?>">

            <label for="size">Size <span style="color:red;">*</span></label>
            <select name="size" required>
                <option value="">--Select--</option>
                <?php
                mysqli_data_seek($sizeQuery, 0);
                while ($size = mysqli_fetch_assoc($sizeQuery)):
                ?>
                    <option value="<?= htmlspecialchars($size['size']) ?>"><?= htmlspecialchars($size['size']) ?></option>
                <?php endwhile; ?>
            </select>

            <label for="quantity">Quantity <span style="color:red;">*</span></label>
            <input type="number" name="quantity" min="1" max="<?= $product['stock'] ?>" value="1" required>

            <button type="submit">Buy Now</button>
        </form>
    </div>
</div>

<script>
// select project-info-form, save user selected product infor required for payment int sesssion for providing to call khati endpoint and after setting info to session contine form action as specified
document.querySelector('.product-info-form').addEventListener('submit', function(event) {
    const formData = new FormData(this);
    const productInfo = {
        product_id: formData.get('product_id'),
        size: formData.get('size'),
        quantity: formData.get('quantity')
    };

    // Save to session storage or send to server as needed
    sessionStorage.setItem('selectedProduct', JSON.stringify(productInfo));
    // Continue with the form submission
    this.submit();
});

</script>

</body>
</html>
