<?php 
session_start();
include 'components/head.php'; 
include '../CONFIG/config.php'; // DB connection

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch user details
$stmt = $conn->prepare("SELECT * FROM users WHERE id=?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Handle update
if(isset($_POST['update_profile'])){
    $fname = trim($_POST['first_name']);
    $lname = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $mobile = trim($_POST['mobile']);
    $username = trim($_POST['username']);

    $update = $conn->prepare("UPDATE users SET first_name=?, last_name=?, email=?, mobile=?, username=? WHERE id=?");
    $update->bind_param("sssssi", $fname, $lname, $email, $mobile, $username, $user_id);

    if($update->execute()){
        $_SESSION['success'] = "Profile updated successfully!";
        header("Location: index.php");
        exit;
    } else {
        $error = "Something went wrong!";
    }
}
?>

<body>
<?php include 'components/navbar.php'; ?>

<style>   
html, body {
  height: 100%;
  margin: 0;
}

body {
  display: flex;
  flex-direction: column;
  min-height: 100vh;
}

main {
  flex: 1;
}
</style>

<div class="content">
  <div class="pt-4"></div>

  <!-- Profile Section -->
  <main class="container my-4">
    <div class="card shadow-sm p-4">
      <h4 class="mb-3">👤 My Profile</h4>
      <?php if(isset($_SESSION['success'])): ?>
        <div class="alert alert-success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
      <?php endif; ?>
      <?php if(isset($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
      <?php endif; ?>
      
      <p><strong>Name:</strong> <?php echo htmlspecialchars($user['first_name'].' '.$user['last_name']); ?></p>
      <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
      <p><strong>Mobile:</strong> <?php echo htmlspecialchars($user['mobile']); ?></p>
      <p><strong>Username:</strong> <?php echo htmlspecialchars($user['username']); ?></p>

      <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#updateModal">Update Profile</button>
    </div>
  </main>

  <!-- Update Profile Modal -->
  <div class="modal fade" id="updateModal" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <form method="POST" id="updateForm" novalidate>
          <div class="modal-header bg-success text-white">
            <h5 class="modal-title">Update Profile</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label>First Name</label>
              <input type="text" name="first_name" id="first_name" class="form-control" value="<?php echo $user['first_name']; ?>" required>
              <div class="invalid-feedback">First name must contain only letters.</div>
            </div>
            <div class="mb-3">
              <label>Last Name</label>
              <input type="text" name="last_name" id="last_name" class="form-control" value="<?php echo $user['last_name']; ?>" required>
              <div class="invalid-feedback">Last name must contain only letters.</div>
            </div>
            <div class="mb-3">
              <label>Email</label>
              <input type="email" name="email" id="email" class="form-control" value="<?php echo $user['email']; ?>" required>
              <div id="emailFeedback" class="form-text"></div>
            </div>
            <div class="mb-3">
              <label>Mobile</label>
              <input type="text" name="mobile" id="mobile" class="form-control" value="<?php echo $user['mobile']; ?>" maxlength="10" required>
              <div class="invalid-feedback">Enter a valid 10-digit mobile number.</div>
            </div>
            <div class="mb-3">
              <label>Username</label>
              <input type="text" name="username" id="username" class="form-control" value="<?php echo $user['username']; ?>" required>
              <div id="usernameFeedback" class="form-text"></div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" name="update_profile" class="btn btn-success">Update</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <div class="copyrights mt-4 text-center py-2 bg-light">
    <p class="mb-0">Kerala Tourism. All Rights Reserved | <a href="#">Kerala Tourism</a></p>
  </div>
</div>

<!-- JS Validation -->
<script>
document.addEventListener("DOMContentLoaded", function() {
  const form = document.getElementById("updateForm");
  const fname = document.getElementById("first_name");
  const lname = document.getElementById("last_name");
  const email = document.getElementById("email");
  const mobile = document.getElementById("mobile");
  const username = document.getElementById("username");
  const emailFeedback = document.getElementById("emailFeedback");
  const usernameFeedback = document.getElementById("usernameFeedback");

  // Validation regex patterns
  const isNameValid = v => /^[A-Za-z]+$/.test(v);
  const isEmailValid = v => /^[^@\s]+@[^@\s]+\.[^@\s]+$/.test(v);
  const isMobileValid = v => /^[0-9]{10}$/.test(v);
  const isUsernameValid = v => /^[A-Za-z0-9_]{4,15}$/.test(v);

  // Toggle helper
  function toggleValidity(el, valid) {
    el.classList.toggle("is-valid", valid);
    el.classList.toggle("is-invalid", !valid);
  }

  // Real-time field validation
  [fname, lname].forEach(i => {
    i.addEventListener("input", () => toggleValidity(i, isNameValid(i.value)));
  });
  mobile.addEventListener("input", () => toggleValidity(mobile, isMobileValid(mobile.value)));

  email.addEventListener("input", () => {
    const val = email.value.trim();
    if (!isEmailValid(val)) {
      toggleValidity(email, false);
      emailFeedback.textContent = "Invalid email format.";
      emailFeedback.className = "form-text text-danger";
      return;
    }

    fetch(`validate_user.php?email=${encodeURIComponent(val)}&exclude_id=<?php echo $user_id; ?>`)
      .then(r => r.json())
      .then(d => {
        if (d.exists) {
          toggleValidity(email, false);
          emailFeedback.textContent = "❌ Email already in use.";
          emailFeedback.className = "form-text text-danger";
        } else {
          toggleValidity(email, true);
          emailFeedback.textContent = "✅ Email looks good!";
          emailFeedback.className = "form-text text-success";
        }
      });
  });

  username.addEventListener("input", () => {
    const val = username.value.trim();
    if (!isUsernameValid(val)) {
      toggleValidity(username, false);
      usernameFeedback.textContent = "Username must be 4–15 chars (letters, numbers, underscore).";
      usernameFeedback.className = "form-text text-danger";
      return;
    }

    fetch(`validate_user.php?username=${encodeURIComponent(val)}&exclude_id=<?php echo $user_id; ?>`)
      .then(r => r.json())
      .then(d => {
        if (d.exists) {
          toggleValidity(username, false);
          usernameFeedback.textContent = "❌ Username already taken.";
          usernameFeedback.className = "form-text text-danger";
        } else {
          toggleValidity(username, true);
          usernameFeedback.textContent = "✅ Username available!";
          usernameFeedback.className = "form-text text-success";
        }
      });
  });

  // Final submission validation
  form.addEventListener("submit", function(e) {
    const valid = (
      isNameValid(fname.value) &&
      isNameValid(lname.value) &&
      isEmailValid(email.value) &&
      isMobileValid(mobile.value) &&
      isUsernameValid(username.value)
    );

    if (!valid) {
      e.preventDefault();
      form.classList.add("was-validated");
      alert("⚠️ Please correct highlighted fields before updating.");
    }
  });
});
</script>

<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
