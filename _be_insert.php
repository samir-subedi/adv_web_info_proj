<?php require_once('connections/conn.php'); ?>
<?php include('include/_authen.php'); ?>
<?php include('include/_authen_admin.php'); ?>

<?php
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = "INSERT INTO products (photo, price, name, label, description, gender, size) VALUES (?, ?, ?, ?, ?, ?, ?)";
  $stmt = $conn->prepare($insertSQL);
  $stmt->bind_param("sdsssss",
                     $_POST['photo'],
                     $_POST['price'],
                     $_POST['name'],
                     $_POST['label'],
                     $_POST['description'],
                     $_POST['gender'],
                     $_POST['size']);

  $stmt->execute();
  $stmt->close();

  $insertGoTo = "_be_interface.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

?>

<?php
  include ("include/header_nav.php");
?>
<main class="backend">

  <h2>Backend Insert Page</h2>
  <p>This page inserts a new Product</p>
  
  <p><a href="_be_interface.php">Go back to Backend Interface page </a></p>
  
  <form action="<?php echo $editFormAction; ?>" id="form1" name="form1" method="POST">
    <p>&nbsp;</p>
    <table width="500" border="1" align="center" cellpadding="4">
      <tr>
        <td width="153" align="right">Name</td>
        <td width="3">&nbsp;</td>
        <td width="304"><label>
          <input type="text" name="name" id="name" required/>
        </label></td>
      </tr>
      <tr>
        <td align="right">Label</td>
        <td>&nbsp;</td>
        <td><label>
          <input name="label" type="text" id="label" size="35" required/>
        </label></td>
      </tr>
      <tr>
        <td align="right">Gender</td>
        <td>&nbsp;</td>
        <td><label>
          <select name="gender" id="gender">
            <option value="M">M</option>
            <option value="F" selected="selected">F</option>
          </select>
        </label></td>
      </tr>
      <tr>
        <td align="right">Size</td>
        <td>&nbsp;</td>
        <td><label>
          <select name="size" id="size">
            <option value="M" selected="selected">M</option>
            <option value="L">L</option>
            <option value="S">S</option>
          </select>
        </label></td>
      </tr>
      <tr>
        <td align="right">Photo</td>
        <td>&nbsp;</td>
        <td><label>
          <input name="photo" type="text" id="photo" size="20" required/>
        </label></td>
      </tr>
      <tr>
        <td align="right">Price</td>
        <td>&nbsp;</td>
        <td><label>
          <input name="price" type="number" id="price" size="6" required/>
        </label></td>
      </tr>
      <tr>
        <td align="right">Description</td>
        <td>&nbsp;</td>
        <td><label>
          <textarea name="description" cols="35" rows="6" id="description" required></textarea>
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
    
    <input type="hidden" name="MM_insert" value="form1" />
  </form>

</main>
<?php
  include ("include/footer.php");
?>
