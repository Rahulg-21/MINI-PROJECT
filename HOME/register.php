<?php
include '../CONFIG/config.php'; // DB connection file
?>

<?php include 'components/head.php'; ?>
<body>
<?php include 'components/pre-loader.php'; ?>
<header class="main_header_arae"></header>
<?php include 'components/navbar.php'; ?>

<div class="container my-5">
  <div class="row justify-content-center">
    <div class="col-lg-6 col-md-8">

      <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
        <div class="card-header text-white" style="background: linear-gradient(90deg, #2e7d32, #66bb6a);">
          <h4 class="fw-bold mb-0"><i class="bi bi-person-plus me-2"></i> Create Your Account</h4>
        </div>

        <div class="card-body p-5">
          <?php if (!empty($message)): ?>
            <div class="alert alert-danger"><?= $message ?></div>
          <?php endif; ?>

          <form method="post" action="regfn.php" id="registerForm" class="row g-3 needs-validation" novalidate>

            <!-- First Name -->
            <div class="col-md-6">
              <label class="form-label fw-semibold"><i class="bi bi-person"></i> First Name</label>
              <input type="text" name="first_name" id="reg_first_name" class="form-control rounded-pill" required>
              <div class="invalid-feedback">First name must contain only letters.</div>
            </div>

            <!-- Last Name -->
            <div class="col-md-6">
              <label class="form-label fw-semibold"><i class="bi bi-person"></i> Last Name</label>
              <input type="text" name="last_name" id="reg_last_name" class="form-control rounded-pill" required>
              <div class="invalid-feedback">Last name must contain only letters.</div>
            </div>

            <!-- Email -->
            <div class="col-12">
              <label class="form-label fw-semibold"><i class="bi bi-envelope"></i> Email</label>
              <input type="email" name="email" id="reg_email" class="form-control rounded-pill" required>
              <div id="reg_emailFeedback" class="form-text"></div>
            </div>

            <!-- Mobile -->
            <div class="col-12">
              <label class="form-label fw-semibold"><i class="bi bi-phone"></i> Mobile</label>
              <input type="text" name="mobile" id="reg_mobile" class="form-control rounded-pill" required maxlength="10">
              <div class="invalid-feedback">Enter a valid 10-digit mobile number.</div>
            </div>

            <!-- Username -->
            <div class="col-12">
              <label class="form-label fw-semibold"><i class="bi bi-person-circle"></i> Username</label>
              <input type="text" name="username" id="reg_username" class="form-control rounded-pill" required>
              <div id="reg_usernameFeedback" class="form-text"></div>
            </div>

            <!-- Password -->
            <div class="col-12">
              <label class="form-label fw-semibold"><i class="bi bi-lock"></i> Password</label>
              <div class="input-group">
                <input type="password" name="password" id="reg_password" class="form-control rounded-start-pill" required>
                <button type="button" class="btn btn-outline-secondary rounded-end-pill" id="reg_togglePassword">
                  <i class="bi bi-eye"></i>
                </button>
              </div>
              <div id="reg_passwordFeedback" class="form-text"></div>
            </div>

            <div class="col-12 d-grid mt-4">
              <button type="submit" class="btn btn-success btn-lg rounded-pill shadow-sm">
                <i class="bi bi-person-plus me-2"></i> Register
              </button>
            </div>
          </form>

          <div class="text-center mt-4">
            <p class="mb-0">Already have an account? 
              <a href="login.php" class="fw-bold text-success">Login Now</a>
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include 'components/footer.php'; ?>

<!-- ✅ Real-Time Validation Script -->
<script>
document.addEventListener("DOMContentLoaded", function() {
  const form = document.getElementById("registerForm");
  const firstName = document.getElementById("reg_first_name");
  const lastName = document.getElementById("reg_last_name");
  const email = document.getElementById("reg_email");
  const mobile = document.getElementById("reg_mobile");
  const username = document.getElementById("reg_username");
  const password = document.getElementById("reg_password");
  const togglePassword = document.getElementById("reg_togglePassword");

  const emailFeedback = document.getElementById("reg_emailFeedback");
  const usernameFeedback = document.getElementById("reg_usernameFeedback");
  const passwordFeedback = document.getElementById("reg_passwordFeedback");

  // Default states
  email.dataset.valid = "false";
  username.dataset.valid = "false";

  // Validation helpers
  const isNameValid = v => /^[A-Za-z]+$/.test(v);
  const isMobileValid = v => /^[0-9]{10}$/.test(v);
  const isUsernameValid = v => /^[A-Za-z0-9_]{4,15}$/.test(v);
  const isEmailValid = v => /^[^@\s]+@[^@\s]+\.[^@\s]+$/.test(v);
  const isPasswordStrong = v => (
    /.{8,}/.test(v) && /[A-Za-z]/.test(v) && /[0-9]/.test(v) && /[!@#$%^&*(),.?":{}|<>]/.test(v)
  );

  function toggleValidity(el, valid) {
    el.classList.toggle("is-valid", valid);
    el.classList.toggle("is-invalid", !valid);
  }

  // Real-time field validation
  [firstName, lastName].forEach(input => {
    input.addEventListener("input", () => toggleValidity(input, isNameValid(input.value)));
  });

  mobile.addEventListener("input", () => toggleValidity(mobile, isMobileValid(mobile.value)));

  password.addEventListener("input", () => {
    const strong = isPasswordStrong(password.value);
    toggleValidity(password, strong);
    passwordFeedback.textContent = strong
      ? "✅ Strong password!"
      : "❌ Must be ≥8 chars, include letters, numbers, and symbols.";
    passwordFeedback.className = strong ? "form-text text-success" : "form-text text-danger";
  });

  // Email validation + AJAX
  email.addEventListener("input", () => {
    const value = email.value.trim();
    if (!isEmailValid(value)) {
      toggleValidity(email, false);
      emailFeedback.textContent = "Invalid email format.";
      emailFeedback.className = "form-text text-danger";
      email.dataset.valid = "false";
      return;
    }

    fetch("validate_user.php?email=" + encodeURIComponent(value))
      .then(r => r.json())
      .then(data => {
        if (data.exists) {
          toggleValidity(email, false);
          emailFeedback.textContent = "❌ Email already registered.";
          emailFeedback.className = "form-text text-danger";
          email.dataset.valid = "false";
        } else {
          toggleValidity(email, true);
          emailFeedback.textContent = "✅ Email looks good!";
          emailFeedback.className = "form-text text-success";
          email.dataset.valid = "true";
        }
      });
  });

  // Username validation + AJAX
  username.addEventListener("input", () => {
    const value = username.value.trim();
    if (!isUsernameValid(value)) {
      toggleValidity(username, false);
      usernameFeedback.textContent = "Username must be 4–15 chars (letters, numbers, underscore).";
      usernameFeedback.className = "form-text text-danger";
      username.dataset.valid = "false";
      return;
    }

    fetch("validate_user.php?username=" + encodeURIComponent(value))
      .then(r => r.json())
      .then(data => {
        if (data.exists) {
          toggleValidity(username, false);
          usernameFeedback.textContent = "❌ Username already taken.";
          usernameFeedback.className = "form-text text-danger";
          username.dataset.valid = "false";
        } else {
          toggleValidity(username, true);
          usernameFeedback.textContent = "✅ Username available!";
          usernameFeedback.className = "form-text text-success";
          username.dataset.valid = "true";
        }
      });
  });

  // Toggle password visibility
  togglePassword.addEventListener("click", () => {
    const type = password.type === "password" ? "text" : "password";
    password.type = type;
    togglePassword.innerHTML = type === "password" ? '<i class="bi bi-eye"></i>' : '<i class="bi bi-eye-slash"></i>';
  });

  // Final submit validation
  form.addEventListener("submit", async function (e) {
    e.preventDefault();

    const valid =
      isNameValid(firstName.value) &&
      isNameValid(lastName.value) &&
      isMobileValid(mobile.value) &&
      isUsernameValid(username.value) &&
      isEmailValid(email.value) &&
      isPasswordStrong(password.value);

    const emailOk = email.dataset.valid === "true";
    const usernameOk = username.dataset.valid === "true";

    if (!valid) {
      form.classList.add("was-validated");
      alert("⚠️ Please correct the highlighted fields before submitting.");
      return;
    }

    if (!emailOk || !usernameOk) {
      const [emailRes, userRes] = await Promise.all([
        fetch("validate_user.php?email=" + encodeURIComponent(email.value)).then(r => r.json()),
        fetch("validate_user.php?username=" + encodeURIComponent(username.value)).then(r => r.json())
      ]);
      if (emailRes.exists || userRes.exists) {
        alert("❌ Email or username already exists. Please choose another.");
        return;
      }
    }

    form.submit(); // ✅ Now submit normally
  });
});
</script>
