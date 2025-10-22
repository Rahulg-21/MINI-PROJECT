<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);


include '../CONFIG/config.php'; // DB connection ($conn)
$message = "";

// Handle login
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['username'], $_POST['password'])) {
    $username = mysqli_real_escape_string($conn, trim($_POST['username']));
    $password = mysqli_real_escape_string($conn, trim($_POST['password']));

    if (!empty($username) && !empty($password)) {
        $sql = "SELECT id, password FROM users WHERE username='$username' OR email='$username' LIMIT 1";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);

            if (password_verify($password, $row['password'])) {
                $_SESSION['user_id'] = $row['id'];
                echo "<script>
                        alert('Login Successful ✅');
                        window.location='index.php';
                      </script>";
                exit();
            } else {
                $message = "Invalid password!";
            }
        } else {
            $message = "Invalid username/email!";
        }
    } else {
        $message = "Please fill in all fields!";
    }
}
?>

<!-- Login Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-md">
    <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
      
      <div class="modal-header text-white" style="background: linear-gradient(90deg, #00695c, #26a69a);">
        <h5 class="modal-title fw-bold" id="loginModalLabel">
          <i class="bi bi-box-arrow-in-right me-2"></i> Login to Kerala Tourism
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body p-5">
        <div class="text-center mb-4">
          <h4 class="fw-bold text-success">Welcome Back!</h4>
          <p class="text-muted">Login to explore districts, book hotels, and discover tourist spots.</p>
        </div>

        <?php if (!empty($message)): ?>
          <div class="alert alert-danger text-center"><?= $message ?></div>
        <?php endif; ?>

        <form method="post" id="loginForm" class="row g-3 needs-validation" novalidate>
          <div class="col-12">
            <label for="username" class="form-label fw-semibold">
              <i class="bi bi-person"></i> Username or Email
            </label>
            <input type="text" class="form-control rounded-pill" id="username" name="username" required>
            <div class="invalid-feedback">Please enter a valid username or email.</div>
            <div id="usernameFeedback" class="form-text"></div>
          </div>

          <div class="col-12">
            <label for="password" class="form-label fw-semibold">
              <i class="bi bi-lock"></i> Password
            </label>
            <input type="password" class="form-control rounded-pill" id="password" name="password" required>
            <div class="invalid-feedback">Password cannot be empty.</div>
          </div>

          <div class="col-12 d-grid mt-4">
            <button type="submit" class="btn btn-success btn-lg rounded-pill shadow-sm">
              <i class="bi bi-box-arrow-in-right me-2"></i> Login
            </button>
          </div>
        </form>

        <div class="text-center mt-4">
          <p class="mb-0">Don’t have an account? 
            <a href="register.php" class="fw-bold text-success">Register Now</a>
          </p>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- ✅ JS: Real-Time Validation -->
<!-- ✅ JS: Real-Time Validation -->
<script>
document.addEventListener("DOMContentLoaded", function() {
  const usernameField = document.getElementById("username");
  const passwordField = document.getElementById("password");
  const usernameFeedback = document.getElementById("usernameFeedback");
  const form = document.getElementById("loginForm");

  // Real-time username/email validation
  usernameField.addEventListener("input", () => {
    const value = usernameField.value.trim();
    if (value === "") {
      usernameFeedback.textContent = "Username or email is required.";
      usernameFeedback.className = "form-text text-danger";
      return;
    }

    // Email format check
    if (value.includes("@") && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value)) {
      usernameFeedback.textContent = "Invalid email format.";
      usernameFeedback.className = "form-text text-danger";
      return;
    }

    // Optional AJAX check for existence
    fetch("validate_user.php?username=" + encodeURIComponent(value))
      .then(res => res.json())
      .then(data => {
        if (data.exists) {
          usernameFeedback.textContent = "✅ Account found!";
          usernameFeedback.className = "form-text text-success";
        } else {
          usernameFeedback.textContent = "❌ No account found with this username/email.";
          usernameFeedback.className = "form-text text-danger";
        }
      });
  });

  // Password validation rules
  function validatePassword(password) {
    const minLength = /.{8,}/;
    const hasLetter = /[A-Za-z]/;
    const hasNumber = /[0-9]/;
    const hasSpecial = /[!@#$%^&*(),.?":{}|<>]/;

    if (!minLength.test(password)) {
      return "Password must be at least 8 characters long.";
    }
    if (!hasLetter.test(password)) {
      return "Password must contain at least one letter.";
    }
    if (!hasNumber.test(password)) {
      return "Password must contain at least one number.";
    }
    if (!hasSpecial.test(password)) {
      return "Password must contain at least one special character (!@#$%^&* etc).";
    }
    return "";
  }

  // Password field validation (real-time)
  passwordField.addEventListener("input", () => {
    const feedback = validatePassword(passwordField.value.trim());
    let feedbackElement = passwordField.nextElementSibling; // .invalid-feedback div

    if (feedback !== "") {
      feedbackElement.textContent = feedback;
      passwordField.classList.remove("is-valid");
      passwordField.classList.add("is-invalid");
    } else {
      feedbackElement.textContent = "Looks good!";
      passwordField.classList.remove("is-invalid");
      passwordField.classList.add("is-valid");
    }
  });

  // Bootstrap validation on submit
  form.addEventListener("submit", (event) => {
    const passwordError = validatePassword(passwordField.value.trim());

    if (!form.checkValidity() || passwordError !== "") {
      event.preventDefault();
      event.stopPropagation();
      if (passwordError !== "") {
        passwordField.classList.add("is-invalid");
        passwordField.nextElementSibling.textContent = passwordError;
      }
    }
    form.classList.add("was-validated");
  });
});
</script>
