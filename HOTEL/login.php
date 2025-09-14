<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../CONFIG/config.php';
session_start();

$message = "";

// Handle Form Submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, trim($_POST['username']));
    $password = mysqli_real_escape_string($conn, trim($_POST['password']));

    // Fetch hotel with approved status
    $stmt = $conn->prepare("SELECT id, password, status, name FROM hotels WHERE username=? LIMIT 1");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $hashed_password, $status, $hotel_name);
    
    if ($stmt->num_rows > 0) {
        $stmt->fetch();
        if ($status !== "Approved") {
            $message = "Your account is not approved yet!";
        } elseif (password_verify($password, $hashed_password)) {
            // Login success
            $_SESSION['hotel_id'] = $id;
            $_SESSION['hotel_name'] = $hotel_name;
            header("Location: dashboard.php"); // Redirect to hotel dashboard
            exit;
        } else {
            $message = "Invalid username or password!";
        }
    } else {
        $message = "Invalid username or password!";
    }

    $stmt->close();
}
?>

<?php include 'components/head.php'; ?>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
  <div class="container">
    <a class="navbar-brand fw-bold text-success" href="index.php">
      <i class="bi bi-building"></i> Kerala Tourism Hotels
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
  </div>
</nav>

<div class="container my-5">
  <div class="row justify-content-center">
    <div class="col-lg-5 col-md-7">
      <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
        <div class="card-header text-white" style="background: linear-gradient(90deg, #2e7d32, #66bb6a);">
          <h4 class="fw-bold mb-0"><i class="bi bi-box-arrow-in-right me-2"></i> Hotel Login</h4>
        </div>

        <div class="card-body p-5">
          <?php if ($message): ?>
            <div class="alert alert-danger"><?= $message ?></div>
          <?php endif; ?>

          <form method="post" class="row g-3">
            <div class="col-12">
              <label class="form-label fw-semibold">Username</label>
              <input type="text" name="username" class="form-control rounded-pill" required>
            </div>
            <div class="col-12">
              <label class="form-label fw-semibold">Password</label>
              <input type="password" name="password" class="form-control rounded-pill" required>
            </div>
            <div class="col-12 d-grid mt-4">
              <button type="submit" class="btn btn-success btn-lg rounded-pill shadow-sm">
                Login
              </button>
            </div>
          </form>

          <div class="text-center mt-3">
            <p class="mb-0">Don't have an account? 
              <a href="hotel_register.php" class="fw-bold text-success">Register Now</a>
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Footer -->
<footer class="bg-light text-center py-3 mt-5 border-top">
  <div class="container">
    <p class="mb-0 text-muted">&copy; <?= date('Y') ?> Kerala Tourism Hotels. All Rights Reserved.</p>
  </div>
</footer>

</body>
</html>
