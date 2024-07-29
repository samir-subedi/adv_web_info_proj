<?php require_once('connections/conn.php'); ?>
<?php include('include/_authen.php'); ?>

<?php

$conn->select_db($database);
$query_ProductsMen = "SELECT * FROM products WHERE gender = 'M'";
$ProductsMen = $conn->query($query_ProductsMen);

$row_ProductsMen = $ProductsMen->fetch_assoc();
$totalRows_ProductsMen = $ProductsMen->num_rows;
?>

<?php
	include ("include/header_nav.php");
?>

<main class="image_a">
	<p id="search_pad">Logged in as <?php echo $_SESSION['MM_Username']; ?></p>
	<h2>Products - Men</h2>

    <?php
    if ($ProductsMen->num_rows > 0) {
        do {
    ?>
            <a href="products_detail.php?product_id=<?php echo $row_ProductsMen['product_id']; ?>"><img width="200" src="images/products/<?php echo $row_ProductsMen['photo']; ?>" border="0" /></a>
    <?php
        } while ($row_ProductsMen = $ProductsMen->fetch_assoc());
    } else {
        echo "No products found.";
    }
    ?>
</main>

<?php
$ProductsMen->free_result();
include("include/footer.php");
?>