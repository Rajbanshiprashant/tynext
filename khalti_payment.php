<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "trynext");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $user_id = $_SESSION['user_id'];
    $product_id = $_GET['product_id'];
    $size = $_GET['size'];
    $quantity = $_GET['quantity'];
    $product_price = $_GET['product_price'];

    // Fetch user details
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if (!$user) {
        die("❌ User not found.");
    }

    $full_name = $user['email'];
    $phone = $user['phone'];
    $address = $user['address'];

    // Check product availability
    $productRes = mysqli_query($conn, "SELECT price, stock FROM products WHERE id = $product_id");
    $product = mysqli_fetch_assoc($productRes);

    if (!$product || $product['stock'] < $quantity) {
        die("❌ Product not found or insufficient stock.");
    }

    $price = $product['price'];
    $total = $price * $quantity;

    // Insert order
    mysqli_query($conn, "
        INSERT INTO orders (user_id, total_amount, status, payment_status, full_name, phone, shipping_address)
        VALUES (
            $user_id,
            $total,
            'Pending',
            'khalti',
            '" . mysqli_real_escape_string($conn, $full_name) . "',
            '" . mysqli_real_escape_string($conn, $phone) . "',
            '" . mysqli_real_escape_string($conn, $address) . "'
        )
    ");

    $order_id = mysqli_insert_id($conn);
    // store product ID in session
    $_SESSION['product_id'] = $product_id;
    // store quantity in session
    $_SESSION['quantity'] = $quantity;

    // Insert order items
    mysqli_query($conn, "
       INSERT INTO orders (user_id, total_amount, status, payment_status, full_name, phone, shipping_address)
        VALUES ($order_id, $product_id, $quantity, $price, '" . mysqli_real_escape_string($conn, $full_name) . "', '" . mysqli_real_escape_string($conn, $phone) . "', '" . mysqli_real_escape_string($conn, $address) . "')
    ");

    //store price in total price in session
    $_SESSION['total_price'] = $quantity * $product_price;

    // Prepare data for Khalti
    $total_price = $quantity * $product_price * 100; // Khalti uses paisa
    $payload = [
        "return_url" => "http://localhost/trynext/payment_result.php",
        "website_url" => "http://localhost/trynext/index.php",
        "amount" => $total_price,
        "purchase_order_id" => (string)$order_id,
        "purchase_order_name" => "Order by user $user_id",
    ];

    echo("before API call");

    // Call Khalti API
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://dev.khalti.com/api/v2/epayment/initiate/',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => json_encode($payload),
        CURLOPT_HTTPHEADER => array(
            'Authorization: key fc6263c2e35f476ebe0aee5579857e8d',
            'Content-Type: application/json',
        ),
    ));

    $response = curl_exec($curl);

    if (curl_errno($curl)) {
        echo "Curl error: " . curl_error($curl);
        curl_close($curl);
        exit();
    }

    curl_close($curl);

    $response = json_decode($response, true);

    if (isset($response['payment_url'])) {
        header("Location: " . $response['payment_url']);
        exit();
    } else {
        echo "❌ Failed to initiate payment.<br>";
        echo "<pre>";
        print_r($response);
        echo "</pre>";
        exit();
    }
}
