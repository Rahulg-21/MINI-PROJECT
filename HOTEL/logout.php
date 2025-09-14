<?php
session_start();

// Unset only the user_id
unset($_SESSION['hotel_id']);

// Redirect to login page
header("Location: index.php");
exit();
?>
