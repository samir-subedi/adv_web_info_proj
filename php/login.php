<?php
session_start();
if (isset($_SESSION['user_id'])) {
    if ($_SESSION['role'] === 'admin') {
        header("Location: dashboard.php");
    } else {
        header("Location: sales_interface.php");
    }
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require 'php/db_connect.php';
    
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        if ($user['role'] == 'admin') {
            header('Location: dashboard.php');
        } else {
            header('Location: sales_interface.php');
        }
        exit;
    } else {
        $error = "Invalid username or password.";
    }
}
?>

<?php include 'partials/header.php'; ?>
<?php include 'partials/navbar.php'; ?>
<link rel="stylesheet" href="css/style.css"> 

<div class="carrot-login">
    <h2>Login</h2>
    <?php if (isset($error)) { echo "<p>$error</p>"; } ?>
    <form action="login.php" method="POST" onsubmit="return validateLoginForm()">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <button type="submit" class="elephant-submit">Login</button>
    </form>
</div>

<?php include 'partials/footer.php'; ?>
