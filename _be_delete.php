<?php require_once('connections/conn.php'); ?>
<?php
/*
if ((isset($_GET['product_id'])) && ($_GET['product_id'] != "")) {
  $deleteSQL = sprintf("DELETE FROM products WHERE product_id=%s", $_GET['product_id']);
	
	
  mysqli_select_db($conn, $database);
  $Result1 = mysqli_query($conn, $deleteSQL ) or die(mysqli_error($conn));

  $deleteGoTo = "_be_interface.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $deleteGoTo));
}*/
?>

<?php
	include ("include/header_nav.php");
?>
<main class ="backend">


<h2>Delete Page</h2>
<p>This page has delete code; but we disabled it. This exercise do not need to delete.</p>
<p>Go backk to <a href="_be_interface.php">Backend Interface page</a></p>
	
</main>
<?php
	include ("include/footer.php");
?>
