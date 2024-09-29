<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}
require 'php/db_connect.php';

$id = $_GET['id'];  // Get the product ID from the URL

// Fetch the product details from the database
$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $category = $_POST['category']; // Get the updated category

    // Handle image upload
    $image = $_FILES['image']['name'];
    if (!empty($image)) {
        $target = "images/products/" . basename($image);
        move_uploaded_file($_FILES['image']['tmp_name'], $target);
    } else {
        // If no new image is uploaded, keep the existing one
        $image_stmt = $pdo->prepare("SELECT image FROM products WHERE id = ?");
        $image_stmt->execute([$id]);
        $image = $image_stmt->fetchColumn();
    }

    // Update the product in the database
    $stmt = $pdo->prepare("UPDATE products SET name = ?, description = ?, price = ?, stock = ?, category = ?, image = ? WHERE id = ?");
    $stmt->execute([$name, $description, $price, $stock, $category, $image, $id]);

    // Redirect to inventory page
    header("Location: view_inventory.php");
    exit;
}
?>

<?php include 'partials/header.php'; ?>
<?php include 'partials/navbar.php'; ?>
<link rel="stylesheet" href="css/style.css">

<div class="orange-edit-product">
    <h2>Edit Product</h2>
    <form action="edit_product.php?id=<?= htmlspecialchars($product['id']) ?>" method="post" enctype="multipart/form-data">
        <label for="name">Product Name:</label>
        <input type="text" id="name" name="name" value="<?= htmlspecialchars($product['name']) ?>" required>

        <label for="description">Description:</label>
        <textarea id="description" name="description" required><?= htmlspecialchars($product['description']) ?></textarea>

        <label for="price">Price:</label>
        <input type="number" step="0.01" id="price" name="price" value="<?= htmlspecialchars($product['price']) ?>" required>

        <label for="stock">Stock:</label>
        <input type="number" id="stock" name="stock" value="<?= htmlspecialchars($product['stock']) ?>" required>

        <!-- Pre-fill the category field -->
        <label for="category">Category:</label>
        <input type="text" id="category" name="category" value="<?= htmlspecialchars($product['category']) ?>" required>

        <label for="image">Product Image:</label>
        <input type="file" id="image" name="image">

        <button type="submit" class="elephant-submit">Update Product</button>
    </form>
</div>

<?php include 'partials/footer.php'; ?>
