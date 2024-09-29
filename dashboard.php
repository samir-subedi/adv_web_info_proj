<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}
require 'php/db_connect.php';

// Fetch total number of users
$user_count_stmt = $pdo->query("SELECT COUNT(*) AS total_users FROM users");
$user_count = $user_count_stmt->fetch(PDO::FETCH_ASSOC)['total_users'];

// Fetch total number of products
$product_count_stmt = $pdo->query("SELECT COUNT(*) AS total_products FROM products");
$product_count = $product_count_stmt->fetch(PDO::FETCH_ASSOC)['total_products'];



// Fetch total sales amount
$sales_total_stmt = $pdo->query("SELECT SUM(total_amount) AS total_sales FROM sales");
$total_sales = $sales_total_stmt->fetch(PDO::FETCH_ASSOC)['total_sales'];

// Fetch sales data for the chart
$sales_chart_stmt = $pdo->query("SELECT DATE(created_at) AS sale_date, SUM(total_amount) AS daily_sales FROM sales GROUP BY sale_date");
$sales_chart_data = $sales_chart_stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include 'partials/header.php'; ?>
<?php include 'partials/navbar.php'; ?>

<link rel="stylesheet" href="css/style.css">

<div class="dashboard-container">
    <h2>Admin Dashboard</h2>

    <!-- Statistic Boxes -->
    <div class="dashboard-stats">
        <div class="stat-box green">
            <h3>Total Users</h3>
            <p><?= htmlspecialchars($user_count); ?></p>
        </div>
        <div class="stat-box blue">
            <h3>Total Products</h3>
            <p><?= htmlspecialchars($product_count); ?></p>
        </div>
        <div class="stat-box orange">
            <h3>Total Sales</h3>
            <p>$<?= number_format($total_sales, 2); ?></p>
        </div>
    </div>



    <!-- Sales Chart -->
    <h3>Sales Chart</h3>
    <canvas id="salesChart" width="400" height="200"></canvas>
</div>

<?php include 'partials/footer.php'; ?>

<!-- Chart.js Script -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var ctx = document.getElementById('salesChart').getContext('2d');
    var salesChart = new Chart(ctx, {
        type: 'line',  // You can change this to 'bar' or 'pie' if you want
        data: {
            labels: [
                <?php foreach ($sales_chart_data as $data): ?>
                    '<?= $data['sale_date']; ?>',
                <?php endforeach; ?>
            ],
            datasets: [{
                label: 'Daily Sales',
                data: [
                    <?php foreach ($sales_chart_data as $data): ?>
                        <?= $data['daily_sales']; ?>,
                    <?php endforeach; ?>
                ],
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
