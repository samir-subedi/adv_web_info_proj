<?php require_once('connections/conn.php'); ?>
<?php include('include/_authen.php'); ?>
<?php include('include/_authen_admin.php'); ?>

<?php
mysqli_select_db($conn, $database);
$query_allProducts = "SELECT * FROM products ORDER BY gender, product_id DESC";
$allProducts = mysqli_query($conn, $query_allProducts ) or die(mysqli_error($conn));
$row_allProducts = mysqli_fetch_assoc($allProducts);
$totalRows_allProducts = mysqli_num_rows($allProducts);
?>


<?php
	include ("include/header_nav.php");
?>
<main class ="backend">


<h2>Backend Interface</h2>
<p>This is the page to use the database</p>







<p><a href="_be_insert.php">Insert a record</a></p>
<table width="100%" border="1" cellpadding="6">
  <tr>
    <td><strong>Name</strong></td>
    <td><strong>Photo</strong></td>
    <td><strong>Gender</strong></td>
    <td><strong>Size</strong></td>
    <td><strong>Price</strong></td>
    <td><strong>to do</strong></td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_allProducts['name']; ?></td>
      <td>
	  
	  <img width = 70 height = 100 src = "images/products/<?php echo $row_allProducts['photo']; ?>" />
	  
	  
      
      
      
      </td>
      <td><?php echo $row_allProducts['gender']; ?></td>
      <td><?php echo $row_allProducts['size']; ?></td>
      <td><?php echo $row_allProducts['price']; ?></td>
      <td><a href="_be_delete.php?id=<?php echo $row_allProducts['product_id']; ?>">Delete</a> | <a href="_be_update.php?product_id=<?php echo $row_allProducts['product_id']; ?>">Update</a></td>
    </tr>
    <?php } while ($row_allProducts = mysqli_fetch_assoc($allProducts)); ?>
</table>

<?php
mysqli_free_result($allProducts);
?>
	
</main>
<?php
	include ("include/footer.php");
?>