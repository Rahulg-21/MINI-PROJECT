

<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-md">
    <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
      
      <!-- Modal Header -->
      <div class="modal-header bg-gradient text-white" 
           style="background: linear-gradient(90deg, #00695c, #26a69a);">
        <h5 class="modal-title fw-bold" id="loginModalLabel">
          <i class="bi bi-box-arrow-in-right me-2"></i> Login to Kerala Tourism
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <!-- Modal Body -->
      <div class="modal-body p-5">

        <!-- Title -->
        <div class="text-center mb-4">
          <h4 class="fw-bold text-success">Welcome Back!</h4>
          <p class="text-muted">Login to explore districts, book hotels, and discover tourist spots.</p>
        </div>

        <!-- Login Form -->
        <form action="login_submit.php" method="post" class="row g-3">
          
          <div class="col-12">
            <label class="form-label fw-semibold"><i class="bi bi-person"></i> Username or Email</label>
            <input type="text" class="form-control rounded-pill" name="username" required>
          </div>

          <div class="col-12">
            <label class="form-label fw-semibold"><i class="bi bi-lock"></i> Password</label>
            <input type="password" class="form-control rounded-pill" name="password" required>
          </div>

          <!-- Remember & Forgot Password -->
          <div class="col-12 d-flex justify-content-between align-items-center mt-2">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="rememberMe" name="remember">
              <label class="form-check-label" for="rememberMe"> Remember me</label>
            </div>
            <a href="forgot_password.php" class="text-decoration-none text-success fw-semibold">Forgot Password?</a>
          </div>

          <!-- Submit Button -->
          <div class="col-12 d-grid mt-4">
            <button type="submit" class="btn btn-success btn-lg rounded-pill shadow-sm">
              <i class="bi bi-box-arrow-in-right me-2"></i> Login
            </button>
          </div>
        </form>

     <div class="text-center mt-4"> <p class="mb-0">Don’t have an account? <a href="#" class="fw-bold text-success" data-bs-toggle="modal" data-bs-target="#registerModal" data-bs-dismiss="modal">Register Now</a> </p> </div>

      </div>
    </div>
  </div>
</div>

<?php include 'components/register-modal.php'; ?>
