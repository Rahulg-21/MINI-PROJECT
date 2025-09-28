<?php
include '../CONFIG/config.php'; // DB connection file

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST['first_name'];
    $last_name  = $_POST['last_name'];
    $email      = $_POST['email'];
    $mobile     = $_POST['mobile'];
    $username   = $_POST['username'];
    $password   = $_POST['password'];

    // Check if username or email exists
    $check = $conn->prepare("SELECT * FROM users WHERE email = ? OR username = ?");
    $check->bind_param("ss", $email, $username);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        echo "<script>
                alert('Username or Email already exists!');
                window.location='index.php';
              </script>";
        exit();
    }

    // Hash password
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Insert user
    $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, email, mobile, username, password) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $first_name, $last_name, $email, $mobile, $username, $hashed_password);

    if ($stmt->execute()) {
        echo "<script>
                alert('Successfully Registered!');
                window.location='index.php';
              </script>";
        exit();
    } else {
        $message = "Error: " . $stmt->error;
    }
}
?>
