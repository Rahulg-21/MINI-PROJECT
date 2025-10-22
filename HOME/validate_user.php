<?php
include '../CONFIG/config.php';
header('Content-Type: application/json');

$response = ['exists' => false];

if (isset($_GET['username'])) {
    $username = mysqli_real_escape_string($conn, $_GET['username']);
    $sql = "SELECT id FROM users WHERE username='$username' LIMIT 1";
    $result = mysqli_query($conn, $sql);
    $response['exists'] = mysqli_num_rows($result) > 0;
}

if (isset($_GET['email'])) {
    $email = mysqli_real_escape_string($conn, $_GET['email']);
    $sql = "SELECT id FROM users WHERE email='$email' LIMIT 1";
    $result = mysqli_query($conn, $sql);
    $response['exists'] = mysqli_num_rows($result) > 0;
}

echo json_encode($response);
?>
