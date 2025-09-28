<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../CONFIG/config.php'; // DB connection ($conn)
session_start();

$message = "";

// Handle Login
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['username'], $_POST['password'])) {
    $username = mysqli_real_escape_string($conn, trim($_POST['username']));
    $password = mysqli_real_escape_string($conn, trim($_POST['password']));

    if (!empty($username) && !empty($password)) {
        // Fetch guide by username or email
        $sql = "SELECT id, password, status, first_name, last_name 
                FROM guides 
                WHERE username='$username' OR email='$username' LIMIT 1";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);

            // Verify password
            if (password_verify($password, $row['password'])) {
                if ($row['status'] === 'Approved') {
                    // ✅ Save session
                    $_SESSION['guide_id'] = $row['id'];
                    $_SESSION['guide_name'] = $row['first_name'] . " " . $row['last_name'];

                      echo "<script>
                        alert('Login successful!');
                        window.location='index.php';
                      </script>";
                    exit();
                } else {
                    $message = "⚠️ Your account is pending approval. Please wait for admin.";
                }
            } else {
                $message = "❌ Invalid password!";
            }
        } else {
            $message = "❌ No account found with that username/email!";
        }
    } else {
        $message = "Please enter username and password.";
    }
}
?>

<?php include 'components/head.php'; ?>
<body>
<style>   html, body {
    height: 100%;
    margin: 0;
  }

  body {
    display: flex;
    flex-direction: column;
    min-height: 100vh;
  }

  main {
    flex: 1; /* pushes footer down */
  }</style>

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
  <div class="container">
    <a class="navbar-brand fw-bold text-success" href="index.php">
      <i class="bi bi-tree-fill"></i> Kerala Tourism
    </a>
  </div>
</nav>


<main class="container my-5">
  <div class="row justify-content-center">
    <div class="col-lg-6 col-md-8">

      <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
        <div class="card-header text-white" style="background: linear-gradient(90deg, #2e7d32, #66bb6a);">
          <h4 class="fw-bold mb-0"><i class="bi bi-box-arrow-in-right me-2"></i> Guide Login</h4>
        </div>

        <div class="card-body p-5">
          <?php if ($message): ?>
            <div class="alert alert-danger"><?= $message ?></div>
          <?php endif; ?>

          <form method="post" class="row g-3">
            <div class="col-12">
              <label class="form-label fw-semibold"><i class="bi bi-person-circle"></i> Username / Email</label>
              <input type="text" name="username" class="form-control rounded-pill" required>
            </div>
            <div class="col-12">
              <label class="form-label fw-semibold"><i class="bi bi-lock"></i> Password</label>
              <input type="password" name="password" class="form-control rounded-pill" required>
            </div>
            <div class="col-12 d-grid mt-4">
              <button type="submit" class="btn btn-success btn-lg rounded-pill shadow-sm">
                <i class="bi bi-box-arrow-in-right me-2"></i> Login
              </button>
            </div>
          </form>

          <div class="text-center mt-4">
            <p class="mb-0">Don’t have an account? 
              <a href="register.php" class="fw-bold text-success">Register Here</a>
            </p>
          </div>
        </div>
      </div>

    </div>
  </div>
  </main>

<footer class="bg-light text-center py-3 mt-5 border-top">
  <div class="container">
    <p class="mb-0 text-muted">&copy; <?= date('Y') ?> Kerala Tourism. All Rights Reserved.</p>
  </div>
</footer>
</body>
</html>
