<?php
// logout.php
session_start();

// Destroy all session data
session_unset();
session_destroy();

// Redirect to the login page after logout
function redirect($url) {
    header('Location: '.$url);
    die();
}

redirect('index.html');
exit;
?>
