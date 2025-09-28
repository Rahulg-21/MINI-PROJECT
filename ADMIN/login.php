<?php
session_start();
include '../CONFIG/config.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, trim($_POST['username']));
    $password = mysqli_real_escape_string($conn, trim($_POST['password']));

    if (!empty($username) && !empty($password)) {
        $sql = "SELECT id, password FROM admins WHERE username='$username' OR email='$username' LIMIT 1";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);

            if (password_verify($password, $row['password'])) {
                $_SESSION['admin_id'] = $row['id'];
                $_SESSION['admin_username'] = $username;

                header("Location: index.php");
                exit();
            } else {
                $error = "❌ Invalid password!";
            }
        } else {
            $error = "❌ No admin account found!";
        }
    } else {
        $error = "⚠️ Please enter username and password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Kerala Tourism - Admin Login</title>
  <link href="../css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), 
                  url('../images/kerala-bg.jpg') no-repeat center center/cover;
      color: #fff;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
    }
    .login-card {
      background: rgba(17, 17, 17, 0.92);
      border: 1px solid #28a745;
      border-radius: 15px;
      padding: 35px;
      width: 420px;
      box-shadow: 0 0 25px rgba(0,0,0,0.6);
      animation: fadeIn 0.8s ease-in-out;
    }
    @keyframes fadeIn {
      from {opacity: 0; transform: translateY(-20px);}
      to {opacity: 1; transform: translateY(0);}
    }
    .login-title {
      font-size: 26px;
      font-weight: bold;
      color: #28a745;
    }
    .input-group-text {
      background: #28a745;
      border: none;
      color: #fff;
    }
    .form-control {
      background: #1e1e1e;
      border: none;
      border-radius: 0 10px 10px 0;
      color: #fff;
      padding: 12px;
    }
    .form-control:focus {
      box-shadow: 0 0 8px #28a745;
      border: none;
    }
    .input-group {
      margin-bottom: 20px;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 0 8px rgba(40, 167, 69, 0.3);
    }
    .btn-login {
      background: #28a745;
      color: #fff;
      font-weight: bold;
      padding: 12px;
      border-radius: 10px;
      transition: 0.3s;
    }
    .btn-login:hover {
      background: #218838;
    }
    .brand-logo {
      font-size: 45px;
      color: #28a745;
    }
  </style>
</head>
<body>

<div class="login-card text-center">
  <div class="brand-logo mb-3"><i class="bi bi-tree-fill"></i></div>
  <h3 class="login-title mb-4">Kerala Tourism - Admin Login</h3>

  <?php if ($error): ?>
    <div class="alert alert-danger py-2"><?= $error ?></div>
  <?php endif; ?>

  <form method="post">
    <div class="input-group">
      <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
      <input type="text" name="username" class="form-control" placeholder="Enter username or email" required>
    </div>
    <div class="input-group">
      <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
      <input type="password" name="password" class="form-control" placeholder="Enter password" required>
    </div>
    <button type="submit" class="btn btn-login w-100"><i class="bi bi-box-arrow-in-right"></i> Login</button>
  </form>
</div>

</body>
</html>
