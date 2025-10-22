<?php
include '../CONFIG/config.php';

header('Content-Type: application/json');

if (isset($_GET['username'])) {
    $username = mysqli_real_escape_string($conn, $_GET['username']);
    $sql = "SELECT id FROM users WHERE username='$username' OR email='$username' LIMIT 1";
    $result = mysqli_query($conn, $sql);

    echo json_encode(['exists' => mysqli_num_rows($result) > 0]);
    exit;
}
echo json_encode(['exists' => false]);
?>
