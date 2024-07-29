<?php require_once('connections/conn.php'); ?>
<?php include('include/_authen.php'); ?>
<?php include('include/_authen_admin.php'); ?>

<?php

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
  
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  //echo "hello!";
  $updateSQL = $conn->prepare("UPDATE products SET photo=?, price=?, name=?, label=?, description=?, gender=?, size=? WHERE product_id=?");
  $updateSQL->bind_param("sdsdsssi", $_POST['photo'], $_POST['price'], $_POST['name'], $_POST['label'], $_POST['description'], $_POST['gender'], $_POST['size'], $_POST['product_id']);
  
  if (!$updateSQL->execute()) {
    die("Error executing update statement: " . $updateSQL->error);
  }
  $updateSQL->close();

  $updateGoTo = "_be_interface.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}


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


?>

<?php include ("include/header_nav.php"); ?>

<main class ="backend">
<h2>Backend Update Page</h2>
<p>This page update Product</p>
  
<p><a href="_be_interface.php">Go back to Backend Interface page </a></p>
  
<form action="<?php echo $editFormAction; ?>" id="form1" name="form1" method="POST">
  <p>&nbsp;</p>
  <table width="500" border="1" align="center" cellpadding="4">
    <tr>
      <td width="153" align="right">Name</td>
      <td width="3">&nbsp;</td>
      <td width="304"><label>
        <input name="name" type="text" id="name" value="<?php echo $row_theProduct['name']; ?>" />
        <input name="product_id" type="hidden" id="product_id" value="<?php echo $row_theProduct['product_id']; ?>" />
      </label></td>
    </tr>
    <tr>
      <td align="right">Label</td>
      <td>&nbsp;</td>
      <td><label>
        <input name="label" type="text" id="label" value="<?php echo $row_theProduct['label']; ?>" size="35" />
      </label></td>
    </tr>
    <tr>
      <td align="right">Gender</td>
      <td>&nbsp;</td>
      <td><label>
        <select name="gender" id="gender">
          <option value="M" <?php if (!(strcmp("M", $row_theProduct['gender']))) {echo "selected=\"selected\"";} ?>>M</option>
          <option value="F" <?php if (!(strcmp("F", $row_theProduct['gender']))) {echo "selected=\"selected\"";} ?>>F</option>
        </select>
      </label></td>
    </tr>
    <tr>
      <td align="right">Size</td>
      <td>&nbsp;</td>
      <td><label>
        <select name="size" id="size">
          <option value="M" <?php if (!(strcmp("M", $row_theProduct['size']))) {echo "selected=\"selected\"";} ?>>M</option>
          <option value="L" <?php if (!(strcmp("L", $row_theProduct['size']))) {echo "selected=\"selected\"";} ?>>L</option>
          <option value="S" <?php if (!(strcmp("S", $row_theProduct['size']))) {echo "selected=\"selected\"";} ?>>S</option>
        </select>
      </label></td>
    </tr>
    <tr>
      <td align="right">Photo</td>
      <td>&nbsp;</td>
      <td><label>
        <input name="photo" type="text" id="photo" value="<?php echo $row_theProduct['photo']; ?>" size="20" />
      </label></td>
    </tr>
    <tr>
      <td align="right">Price</td>
      <td>&nbsp;</td>
      <td><label>
        <input name="price" type="text" id="price" value="<?php echo $row_theProduct['price']; ?>" size="6" />
      </label></td>
    </tr>
    <tr>
      <td align="right">Description</td>
      <td>&nbsp;</td>
      <td><label>
        <textarea name="description" cols="35" rows="6" id="description"><?php echo $row_theProduct['description']; ?></textarea>
      </label></td>
    </tr>
    <tr>
      <td height="64" colspan="3" align="center"><label>
        <input type="submit" name="button" id="button" value="Submit" />
      </label>
        <label>
        <input type="reset" name="button2" id="button2" value="Reset" />
      </label></td>
    </tr>
  </table>
  <p>&nbsp;</p>
  
  
  <input type="hidden" name="MM_update" value="form1" />
</form>

</main>

<?php 

$theProduct->free_result();
include ("include/footer.php"); ?>
