<?php
session_start();

// Remove only admin-related session variables
unset($_SESSION['admin_id']);
unset($_SESSION['admin_username']);

// Redirect back to login
header("Location: login.php");
exit();
?>
