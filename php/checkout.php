<?php
session_start();
require 'db_connect.php';  // Include database connection

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "Error: Your cart is empty.";
    exit;
}

// Process the cart items and generate invoice
$invoice = "<h2>Invoice</h2><table border='1' cellpadding='10'>";
$invoice .= "<thead><tr><th>Product Name</th><th>Quantity</th><th>Price</th><th>Total</th></tr></thead><tbody>";

$total_amount = 0;

// Loop through cart items and update stock
foreach ($_SESSION['cart'] as $product_id => $item) {
    $invoice .= "<tr><td>" . htmlspecialchars($item['name']) . "</td>";
    $invoice .= "<td>" . htmlspecialchars($item['quantity']) . "</td>";
    $invoice .= "<td>$" . htmlspecialchars($item['price']) . "</td>";
    $invoice .= "<td>$" . htmlspecialchars($item['total']) . "</td></tr>";

    // Update stock in database
    $stmt = $pdo->prepare("UPDATE products SET stock = stock - ? WHERE id = ?");
    $stmt->execute([$item['quantity'], $product_id]);

    $total_amount += $item['total'];
}

$invoice .= "<tr><td colspan='3'>Total Amount</td><td>$" . htmlspecialchars($total_amount) . "</td></tr>";
$invoice .= "</tbody></table>";

// Clear the cart after checkout
unset($_SESSION['cart']);

echo $invoice;
?>
