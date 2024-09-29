<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}
require 'php/db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $category = $_POST['category']; // Get the category from the form

    // Handle image upload
    $image = $_FILES['image']['name'];
    $target = "images/products/" . basename($image);

    // Insert product into the database
    $stmt = $pdo->prepare("INSERT INTO products (name, description, price, stock, category, image) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$name, $description, $price, $stock, $category, $image]);

    // Move uploaded image to the target directory
    if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
        echo "Image uploaded successfully";
    } else {
        echo "Failed to upload image";
    }

    // Redirect to the inventory view page
    header("Location: view_inventory.php");
    exit;
}
?>

<?php include 'partials/header.php'; ?>
<?php include 'partials/navbar.php'; ?>
<link rel="stylesheet" href="css/style.css">

<div class="apple-add-product">
    <h2>Add New Product</h2>
    <form action="add_product.php" method="post" enctype="multipart/form-data">
        <label for="name">Product Name:</label>
        <input type="text" id="name" name="name" required>
        
        <label for="description">Description:</label>
        <textarea id="description" name="description" required></textarea>

        <label for="price">Price:</label>
        <input type="number" step="0.01" id="price" name="price" required>

        <label for="stock">Stock:</label>
        <input type="number" id="stock" name="stock" required>

        <!-- New Category Field -->
        <label for="category">Category:</label>
        <input type="text" id="category" name="category" required>

        <label for="image">Product Image:</label>
        <input type="file" id="image" name="image">

        <button type="submit" class="elephant-submit">Add Product</button>
    </form>
</div>

<?php include 'partials/footer.php'; ?>
