<?php
require 'db_connect.php';  // Include database connection

$search_query = $_GET['query'] ?? '';  // Get the search query

// Fetch products that match the search query (by name or ID)
$stmt = $pdo->prepare("SELECT * FROM products WHERE name LIKE :query OR id LIKE :query");
$stmt->execute(['query' => '%' . $search_query . '%']);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);  // Fetch as associative array

// If products are found, display them in a table format
if ($products) {
    echo "<table class='grape-search-results'>";
    echo "<thead><tr><th>Product Name</th><th>Category</th><th>Price</th><th>Stock</th><th>Quantity</th><th>Action</th></tr></thead>";
    echo "<tbody>";
    foreach ($products as $product) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($product['name']) . "</td>";
        echo "<td>" . htmlspecialchars($product['category']) . "</td>"; // Show category in the results
        echo "<td>$" . htmlspecialchars($product['price']) . "</td>";
        echo "<td>" . htmlspecialchars($product['stock']) . "</td>";
        echo "<td><input type='number' id='quantity_" . $product['id'] . "' min='1' max='" . $product['stock'] . "' value='1' style='width:60px;'></td>";
        echo "<td><button class='add-to-cart-btn' onclick='addToCart(" . $product['id'] . ")'>Add to Cart</button></td>";
        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";
} else {
    echo "<p>No products found matching your search.</p>";
}
?>
