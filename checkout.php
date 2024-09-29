<?php
session_start();  // Start the session to track the cart

require 'db_connect.php';  // Include the database connection

// Check if the cart is not empty
if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    $total_amount = 0;

    // Calculate the total amount for the sale
    foreach ($_SESSION['cart'] as $item) {
        $total_amount += $item['price'] * $item['quantity'];
    }

    // Insert the sale into the `sales` table
    $stmt = $pdo->prepare("INSERT INTO sales (total_amount) VALUES (?)");
    $stmt->execute([$total_amount]);
    $sale_id = $pdo->lastInsertId();  // Get the ID of the inserted sale

    // Prepare the invoice HTML
    $invoice_html = "<h2>Invoice</h2>";
    $invoice_html .= "<table border='1' cellpadding='10'>";
    $invoice_html .= "<thead><tr><th>Product Name</th><th>Quantity</th><th>Price</th><th>Total</th></tr></thead>";
    $invoice_html .= "<tbody>";

    // Insert each product into the `sales_items` table and update product stock
    foreach ($_SESSION['cart'] as $product_id => $item) {
        // Insert into `sales_items`
        $stmt = $pdo->prepare("INSERT INTO sales_items (sale_id, product_id, quantity_sold, price) VALUES (?, ?, ?, ?)");
        $stmt->execute([$sale_id, $product_id, $item['quantity'], $item['price']]);

        // Update the stock in the `products` table
        $stmt = $pdo->prepare("UPDATE products SET stock = stock - ? WHERE id = ?");
        $stmt->execute([$item['quantity'], $product_id]);

        // Add to the invoice
        $item_total = $item['quantity'] * $item['price'];
        $invoice_html .= "<tr>";
        $invoice_html .= "<td>" . htmlspecialchars($item['name']) . "</td>";
        $invoice_html .= "<td>" . htmlspecialchars($item['quantity']) . "</td>";
        $invoice_html .= "<td>$" . htmlspecialchars($item['price']) . "</td>";
        $invoice_html .= "<td>$" . htmlspecialchars($item_total) . "</td>";
        $invoice_html .= "</tr>";
    }

    // Add total to the invoice
    $invoice_html .= "<tr><td colspan='3'>Total Amount</td><td>$" . htmlspecialchars($total_amount) . "</td></tr>";
    $invoice_html .= "</tbody></table>";

    // Clear the cart after successful checkout
    unset($_SESSION['cart']);

    // Return the invoice HTML as a response
    echo $invoice_html;
} else {
    // Handle empty cart case
    echo "<p>Your cart is empty. Please add items to the cart before checking out.</p>";
}
?>
