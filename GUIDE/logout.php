<?php
session_start();

// Unset only the user_id
unset($_SESSION['guide_id']);

// Redirect to login page
header("Location: index.php");
exit();
?>
