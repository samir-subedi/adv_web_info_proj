<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

require 'php/db_connect.php';  // Include the database connection

// Fetch sales data, including the user (seller) who processed the sale
$sales_stmt = $pdo->prepare("
    SELECT s.id as sale_id, s.total_amount, s.created_at, si.product_id, si.quantity_sold, si.price, p.name as product_name, u.username as seller
    FROM sales s
    JOIN sales_items si ON s.id = si.sale_id
    JOIN products p ON si.product_id = p.id
    JOIN users u ON s.user_id = u.id  -- Fetch the seller (user) information
    ORDER BY s.created_at DESC
");
$sales_stmt->execute();
$sales = $sales_stmt->fetchAll(PDO::FETCH_ASSOC);  // Fetch all sales data
?>

<?php include 'partials/header.php'; ?>
<?php include 'partials/navbar.php'; ?>
<link rel="stylesheet" href="css/style.css">

<div class="orange-report-sales">
    <h2>Sales Report</h2>

    <!-- If there are sales, display them -->
    <?php if (!empty($sales)): ?>
        <table class="orange-report-table">
            <thead>
                <tr>
                    <th>Sale ID</th>
                    <th>Date</th>
                    <th>Product Name</th>
                    <th>Quantity Sold</th>
                    <th>Price</th>
                    <th>Total Sale Amount</th>
                    <th>Seller</th>  <!-- New column for the seller's name -->
                </tr>
            </thead>
            <tbody>
                <?php foreach ($sales as $sale): ?>
                    <tr>
                        <td><?= htmlspecialchars($sale['sale_id']) ?></td>
                        <td><?= htmlspecialchars($sale['created_at']) ?></td> <!-- Adjust if you added a different date column -->
                        <td><?= htmlspecialchars($sale['product_name']) ?></td>
                        <td><?= htmlspecialchars($sale['quantity_sold']) ?></td>
                        <td>$<?= htmlspecialchars($sale['price']) ?></td>
                        <td>$<?= htmlspecialchars($sale['total_amount']) ?></td>
                        <td><?= htmlspecialchars($sale['seller']) ?></td> <!-- Display the seller's name -->
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No sales data available.</p>
    <?php endif; ?>
</div>

<?php include 'partials/footer.php'; ?>
