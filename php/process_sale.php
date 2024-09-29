<?php
session_start();
require 'db_connect.php';  // Include database connection

// Get product ID and quantity from the POST request
$product_id = $_POST['product_id'];
$quantity = $_POST['quantity'];

// Fetch the product details from the database
$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$product_id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

// Check if product is available in the required quantity
if ($product && $product['stock'] >= $quantity) {
    // Add the product to the session cart
    $_SESSION['cart'][$product_id] = [
        'name' => $product['name'],
        'price' => $product['price'],
        'quantity' => $quantity,
        'total' => $product['price'] * $quantity
    ];

    // Generate the updated cart summary
    echo "<ul>";
    foreach ($_SESSION['cart'] as $item) {
        echo "<li>" . htmlspecialchars($item['name']) . " - " . htmlspecialchars($item['quantity']) . " units - $" . htmlspecialchars($item['total']) . "</li>";
    }
    echo "</ul>";
} else {
    echo "Error: Product not available in the requested quantity.";
}
?>
