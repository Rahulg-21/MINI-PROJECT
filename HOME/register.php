<?php include 'components/head.php'; ?>
<body>
<?php include 'components/pre-loader.php'; ?>
<header class="main_header_arae"></header>
<?php include 'components/navbar.php'; ?>

<div class="container my-5">
  <div class="row justify-content-center">
    <div class="col-lg-6 col-md-8">

      <!-- Register Card -->
      <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
        
        <!-- Header -->
        <div class="card-header text-white" 
             style="background: linear-gradient(90deg, #2e7d32, #66bb6a);">
          <h4 class="fw-bold mb-0">
            <i class="bi bi-person-plus me-2"></i> Create Your Account
          </h4>
        </div>

        <!-- Body -->
        <div class="card-body p-5">
          <div class="text-center mb-4">
            <h4 class="fw-bold text-success">Join Kerala Tourism</h4>
            <p class="text-muted">Register now to explore districts, book hotels, and discover tourist spots.</p>
          </div>

          <form action="register_submit.php" method="post" class="row g-3">

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

          <!-- Social Login -->
          <div class="text-center mt-4">
            <div class="line_or my-3">
              
            </div>
            <div>
              <a href="#!" class="mx-2"><img src="assets/img/icon/google.png" alt="Google" width="35"></a>
              <a href="#!" class="mx-2"><img src="assets/img/icon/facebook.png" alt="Facebook" width="35"></a>
              <a href="#!" class="mx-2"><img src="assets/img/icon/twitter.png" alt="Twitter" width="35"></a>
            </div>
          </div>

          <!-- Already Have Account -->
          <div class="text-center mt-4">
            <p class="mb-0">Already have an account? 
              <a href="" class="fw-bold text-success">Login Now</a>
            </p>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>

<?php include 'components/footer.php'; ?>
