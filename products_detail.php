<?php require_once('connections/conn.php'); ?>
<?php include('include/_authen.php'); ?>

<?php

$colname_theProduct = "-1";
if (isset($_GET['product_id'])) {
  $colname_theProduct = $_GET['product_id'];
}
$conn->select_db($database);
$query_theProduct = sprintf("SELECT * FROM products WHERE product_id = %s", $conn->real_escape_string($colname_theProduct));
$theProduct = $conn->query($query_theProduct);
$row_theProduct = $theProduct->fetch_assoc();
$totalRows_theProduct = $theProduct->num_rows;
?>

<?php
	include ("include/header_nav.php");
?>

<main>
	<p id="search_pad">Logged in as <?php echo $_SESSION['MM_Username']; ?></p>
	<h2>Product Detail</h2>
	
	<img id="p_detail_img" src="images/products/<?php echo $row_theProduct['photo']; ?>" width="500px" />
	<div id="p_detail_pad">
		<p><strong>Name</strong> <?php echo $row_theProduct['name']; ?><br />
		  <strong>Label</strong> <?php echo $row_theProduct['label']; ?><br />
		  <strong>Gender</strong> <?php echo $row_theProduct['gender']; ?><br />
		  <strong>Size</strong> <?php echo $row_theProduct['size']; ?><br />
		  <strong>Price</strong> $<?php echo $row_theProduct['price']; ?><br />
		  <strong>Description</strong> <?php echo $row_theProduct['description']; ?></p>

		<form id="form2" name="form2" method="post" action="products_cart.php">
		  <p>&nbsp;</p>
		  <p><strong>Quantity</strong> 
			<label>
			<input name="quantity" type="text" id="quantity" size="5" />
			</label>
			<label>
			<input type="submit" name="button2" id="button2" value="Add to Cart" />
			</label>
			<input name="product_id" type="hidden" id="product_id" value="<?php echo $row_theProduct['product_id']; ?>" />
		  </p>
		  <p>&nbsp;</p>
		</form>
	</div>

	<p></p>
	<p></p>
	<p></p>
	<p></p>
</main>

<?php
$theProduct->free_result();
include ("include/footer.php");
?>
