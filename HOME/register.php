<?php
include '../CONFIG/config.php'; // your DB connection file

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
          <?php if ($message): ?>
            <div class="alert alert-danger"><?= $message ?></div>
          <?php endif; ?>

          <form method="post" action= "regfn.php" class="row g-3">
            <div class="col-md-6">
              <label class="form-label fw-semibold"><i class="bi bi-person"></i> First Name</label>
              <input type="text" name="first_name" class="form-control rounded-pill" required>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-semibold"><i class="bi bi-person"></i> Last Name</label>
              <input type="text" name="last_name" class="form-control rounded-pill" required>
            </div>
            <div class="col-12">
              <label class="form-label fw-semibold"><i class="bi bi-envelope"></i> Email</label>
              <input type="email" name="email" class="form-control rounded-pill" required>
            </div>
            <div class="col-12">
              <label class="form-label fw-semibold"><i class="bi bi-phone"></i> Mobile</label>
              <input type="text" name="mobile" class="form-control rounded-pill" required>
            </div>
            <div class="col-12">
              <label class="form-label fw-semibold"><i class="bi bi-person-circle"></i> Username</label>
              <input type="text" name="username" class="form-control rounded-pill" required>
            </div>
            <div class="col-12">
              <label class="form-label fw-semibold"><i class="bi bi-lock"></i> Password</label>
              <input type="password" name="password" class="form-control rounded-pill" required>
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
