<?php
// db_connect.php

// Database connection settings
$host = 'localhost';  // Change this if you're using a remote DB
$dbname = 'inventory_management';  // Name of the database you created
$username = 'root';  // Default username for localhost (adjust if needed)
$password = '';  // Default password for localhost (adjust if needed)

try {
    // Create a new PDO connection with the specified settings
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    
    // Set the PDO error mode to exception for better error handling
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Optional: Set PDO to use UTF-8 encoding
    $pdo->exec("set names utf8");

} catch (PDOException $e) {
    // If the connection fails, output an error message
    die("Database connection failed: " . $e->getMessage());
}
?>
