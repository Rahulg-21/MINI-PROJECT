<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../CONFIG/config.php'; // DB connection ($conn)

// Default error message
$message = "";

// Handle login
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['username'], $_POST['password'])) {
    $username = mysqli_real_escape_string($conn, trim($_POST['username']));
    $password = mysqli_real_escape_string($conn, trim($_POST['password']));

    if (!empty($username) && !empty($password)) {
        // Fetch user
        $sql = "SELECT id, password FROM users WHERE username='$username' OR email='$username' LIMIT 1";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);

            // Verify hashed password
            if (password_verify($password, $row['password'])) {
                $_SESSION['user_id'] = $row['id']; // set session

                echo "<script>
                        alert('Login Successful ✅');
                        window.location='index.php';
                      </script>";
                exit();
            } else {
                echo "<script>
                        alert('Invalid username/email'  );
          
                      </script>";
            }
        } else {
             echo "<script>
                        alert('Invalid username/email ' );
          
                      </script>";
        }
    } else {
       
         echo "<script>
                        alert('Please fill in all fields!'  );
          
                      </script>";
    }
}
?>

<!-- Login Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-md">
    <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
      
      <!-- Modal Header -->
      <div class="modal-header text-white" style="background: linear-gradient(90deg, #00695c, #26a69a);">
        <h5 class="modal-title fw-bold" id="loginModalLabel">
          <i class="bi bi-box-arrow-in-right me-2"></i> Login to Kerala Tourism
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <!-- Modal Body -->
      <div class="modal-body p-5">

        <div class="text-center mb-4">
          <h4 class="fw-bold text-success">Welcome Back!</h4>
          <p class="text-muted">Login to explore districts, book hotels, and discover tourist spots.</p>
        </div>

        <!-- Error Message -->
        <?php if (!empty($message)): ?>
          <div class="alert alert-danger text-center"><?= $message ?></div>
        <?php endif; ?>

        <!-- Login Form -->
        <form method="post" class="row g-3">

          <div class="col-12">
            <label for="username" class="form-label fw-semibold">
              <i class="bi bi-person"></i> Username or Email
            </label>
            <input type="text" class="form-control rounded-pill" id="username" name="username" required>
          </div>

          <div class="col-12">
            <label for="password" class="form-label fw-semibold">
              <i class="bi bi-lock"></i> Password
            </label>
            <input type="password" class="form-control rounded-pill" id="password" name="password" required>
          </div>

          <div class="col-12 d-grid mt-4">
            <button type="submit" class="btn btn-success btn-lg rounded-pill shadow-sm">
              <i class="bi bi-box-arrow-in-right me-2"></i> Login
            </button>
          </div>
        </form>

        <!-- Register Link -->
        <div class="text-center mt-4">
          <p class="mb-0">Don’t have an account? 
            <a href="register.php" class="fw-bold text-success">Register Now</a>
          </p>
        </div>

      </div>
    </div>
  </div>
</div>
