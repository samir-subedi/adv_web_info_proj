<?php require_once('connections/conn.php'); ?>
<?php 
    include('include/_authen.php'); 
    include ("include/_logoff.php");
?>

<?php
//-- which product?
$colname_theProduct = "-1";
if (isset($_POST['product_id'])) {
  $colname_theProduct = $_POST['product_id'];
}
$conn->select_db($database);
$query_theProduct = sprintf("SELECT * FROM products WHERE product_id = %s", $colname_theProduct);
$theProduct = $conn->query($query_theProduct) or die($conn->error);
$row_theProduct = $theProduct->fetch_assoc();
$totalRows_theProduct = $theProduct->num_rows;



//-- Which user?
$colname_theUser = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_theUser = $_SESSION['MM_Username'];
}
$query_theUser = sprintf("SELECT * FROM users WHERE username = '%s'", $colname_theUser);
$theUser = $conn->query($query_theUser) or die($conn->error);
$row_theUser = $theUser->fetch_assoc();
$user_id = $row_theUser['user_id']; // Assuming 'user_id' is the column name in the 'users' table

//-- Order history by the user

$query_orders = "SELECT p.*, o.*, u.* FROM products as p, orders as o, users as u WHERE o.product_id = p.product_id and o.user_id = u.user_id and u.user_id = '$user_id' ORDER BY order_time Desc";
$orders = $conn->query($query_orders) or die($conn->error);
$totalRows_orders = $orders->num_rows;


?>


<?php include("include/header_nav.php"); ?>

<main>
    <p id="search_pad">Logged in as <strong><?php echo $_SESSION['MM_Username']; ?></strong></p>
    <h2>SHOPPING CART</h2>

    <table width="100%" border="1" cellpadding="4" id="cart">
        <tr>
            <th width=160px><strong>Product Ordered</strong></th>
            <th width=120px><strong>Quantity</strong></th>
            <th width=160px><strong>Unit Price</strong></th>
            <th align="right"><strong>Cost</strong></th>
        </tr>
        <tr>
            <td>
                <img width=100px src="images/products/<?php echo $row_theProduct['photo']; ?>" />
                <br />
                <?php echo $row_theProduct['name']; ?>
            </td>
            <td><?php echo $_POST['quantity']; ?></td>
            <td><?php echo $row_theProduct['price']; ?></td>
            <td align="right">
                $ <?php
                $cost = $_POST['quantity'] * $row_theProduct['price'];
                echo number_format($cost, 2);
                ?>
            </td>
        </tr>

        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td align="right"><strong>GST</strong></td>
            <td align="right">
                $ <?php
                $gst = 0.1 * $cost;
                echo number_format($gst, 2);
                ?>
            </td>
        </tr>

        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td align="right"><strong>Grand Total</strong></td>
            <td align="right">
                $ <?php
                $grand = $cost + $gst;
                echo number_format($grand, 2);
                ?>
            </td>
        </tr>
    </table>

    <p>This is order made by <strong><?php echo $_SESSION['MM_Username']; ?></strong> so far, sorry we don't have check out now<br />
        To see other buyers order list, you must log off <a href="<?php echo $logoutAction ?>" class="linkType2">here</a>.</p>
    <div id="order_list">
        <table width="100%" border="1" id="cart_history">
            <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Date/Time</th>
                <th>Total</th>
                <th>GST</th>
                <th>Grand Total</th>
            </tr>
            <?php if ($totalRows_orders > 0) : ?>
                <?php while ($row_orders = $orders->fetch_assoc()) : ?>
                    <tr>
                        <td><?php echo $row_orders['name']; ?></td>
                        <td><?php echo $row_orders['quantity']; ?></td>
                        <td><?php echo $row_orders['order_time']; ?></td>
                        <td>$ <?php echo number_format($row_orders['total'], 2); ?></td>
                        <td>$ <?php echo number_format($row_orders['total'] * .1, 2); ?></td>
                        <td>$ <?php echo number_format($row_orders['total'] * 1.1, 2); ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else : ?>
                <tr>
                    <td colspan="6">You do not yet have ordered anything; except the one showing above. It will show next time you are in the cart page.</td>
                </tr>
            <?php endif; ?>

        </table>
    </div>

    <?php
    $insert_order = sprintf("INSERT INTO orders (order_time, product_id, quantity, user_id, total) 
                             VALUES ('%s', %d, %d, %d, %.2f)",
                             date('Y-m-d H:i:s'),
                             $row_theProduct['product_id'],
                             $_POST['quantity'],
                             $row_theUser['user_id'],
                           $cost);

    $conn->query($insert_order) or die($conn->error);

    $theProduct->free_result();
    $orders->free_result();
    $theUser->free_result();
    ?>

</main>

<?php include("include/footer.php"); ?>
