<?php require_once('connections/conn.php'); ?>
<?php include('include/_authen.php'); ?>

<?php

$conn->select_db($database);
$query_ProductsWomen = "SELECT * FROM products WHERE gender = 'F'";
$ProductsWomen = $conn->query($query_ProductsWomen);

$row_ProductsWomen = $ProductsWomen->fetch_assoc();
$totalRows_ProductsWomen = $ProductsWomen->num_rows;
?>

<?php
	include ("include/header_nav.php");
?>

<main class="image_a">
	<p id="search_pad">Logged in as <?php echo $_SESSION['MM_Username']; ?></p>
	<h2>Products - Women</h2>

    <?php
    if ($ProductsWomen->num_rows > 0) {
        do {
    ?>
            <a href="products_detail.php?product_id=<?php echo $row_ProductsWomen['product_id']; ?>"><img width="200" src="images/products/<?php echo $row_ProductsWomen['photo']; ?>" border="0" /></a>
    <?php
        } while ($row_ProductsWomen = $ProductsWomen->fetch_assoc());
    } else {
        echo "No products found.";
    }
    ?>
</main>

<?php
$ProductsWomen->free_result();
include("include/footer.php");
?>
