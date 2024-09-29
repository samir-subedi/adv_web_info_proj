<?php
session_start();

// Check if the user is logged in and has either 'admin' or 'salesperson' role
if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['salesperson', 'admin'])) {
    header("Location: login.php"); // Redirect to login if not logged in or not authorized
    exit;
}
require 'php/db_connect.php';  // Include the database connection
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Interface</title>
    <link rel="stylesheet" href="css/style.css"> <!-- Link to your CSS file -->
    <script src="js/cart_checkout.js"></script> <!-- JavaScript for cart and checkout functionality -->
    <script>
        // JavaScript for live search functionality (AJAX)
        function searchProducts() {
            var query = document.getElementById("searchInput").value;
            var xhr = new XMLHttpRequest();
            xhr.open("GET", "php/search_products.php?query=" + query, true);
            xhr.onload = function () {
                if (xhr.status === 200) {
                    document.getElementById("searchResults").innerHTML = xhr.responseText;  // Display search results in table
                } else {
                    console.error("Error fetching search results.");
                }
            };
            xhr.send();
        }

        // Add to Cart function
        function addToCart(productId) {
            let quantity = document.getElementById('quantity_' + productId).value;

            let xhr = new XMLHttpRequest();
            xhr.open('POST', 'php/process_sale.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onload = function () {
                if (xhr.status === 200) {
                    document.getElementById('cartSummary').innerHTML = xhr.responseText; // Update cart summary
                } else {
                    console.error('Error adding to cart');
                }
            };
            xhr.send('product_id=' + productId + '&quantity=' + quantity);  // Send data to server
        }

        // Checkout function
        function checkout() {
            let xhr = new XMLHttpRequest();
            xhr.open('POST', 'php/checkout.php', true);
            xhr.onload = function () {
                if (xhr.status === 200) {
                    document.getElementById('invoice').innerHTML = '';  // Clear previous invoice to avoid duplication
                    document.getElementById('invoice').innerHTML = xhr.responseText;  // Show new invoice
                    document.getElementById('cartSummary').innerHTML = '<p>No items in cart yet.</p>';  // Clear cart
                    document.getElementById('printInvoiceBtn').style.display = 'block'; // Show print button
                } else {
                    console.error('Checkout failed.');
                }
            };
            xhr.send();  // Perform checkout
        }

        // Print invoice function
        function printInvoice() {
            var invoiceContent = document.getElementById('invoice').innerHTML;
            var win = window.open('', '', 'height=700,width=700');
            win.document.write('<html><head><title>Invoice</title>');
            win.document.write('</head><body>');
            win.document.write(invoiceContent);
            win.document.write('</body></html>');
            win.document.close();
            win.print();
        }
    </script>
</head>
<body>
    <?php include 'partials/header.php'; ?>
    <?php include 'partials/navbar.php'; ?>

    <div class="grape-sales-interface">
        <h2>Sales Interface</h2>

        <!-- Search Bar -->
        <div class="search-container">
            <input type="text" id="searchInput" onkeyup="searchProducts()" placeholder="Search products by name or ID...">
        </div>

        <!-- Search Results -->
        <div id="searchResults">
            <!-- Products found through the search will be dynamically inserted here in table format -->
        </div>

        <!-- Cart Summary -->
        <h2>Cart</h2>
        <div id="cartSummary">
            <p>No items in cart yet.</p>
        </div>

        <!-- Invoice Section -->
        
        <div id="invoice">
            <!-- The generated invoice will be displayed here after checkout -->
        </div>

        <!-- Print Invoice Button -->
        <button id="printInvoiceBtn" style="display: none;" class="print-invoice-btn" onclick="printInvoice()">Print Invoice</button>

        <!-- Checkout Button -->
        <button class="checkout-btn" onclick="checkout()">Checkout</button>
    </div>

    <?php include 'partials/footer.php'; ?>
</body>
</html>
