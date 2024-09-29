<?php
session_start();

// Check if the user is already logged in and redirect accordingly
if (isset($_SESSION['user_id'])) {
    if ($_SESSION['role'] === 'admin') {
        header("Location: dashboard.php");
    } else {
        header("Location: sales_interface.php");
    }
    exit;
}

// Process the form when submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require 'php/db_connect.php';  // Database connection
    
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Fetch the user from the database
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch();

    // Compare the plain text password directly
    if ($user && $user['password'] === $password) {
        // Set session variables for logged-in user
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        
        // Redirect the user based on their role
        if ($user['role'] === 'admin') {
            header('Location: dashboard.php');
        } else {
            header('Location: sales_interface.php');
        }
        exit;
    } else {
        // If login fails, show an error message
        $error = "Invalid username or password.";
    }
}
?>

<!-- Include header and navbar -->
<?php include 'partials/header.php'; ?>
<?php include 'partials/navbar.php'; ?>
<link rel="stylesheet" href="css/style.css">

<!-- Login form -->
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

<!-- Include footer -->
<?php include 'partials/footer.php'; ?>
