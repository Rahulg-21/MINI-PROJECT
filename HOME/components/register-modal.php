


<div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
      
      <!-- Modal Header -->
      <div class="modal-header bg-gradient text-white" 
           style="background: linear-gradient(90deg, #1b5e20, #388e3c);">
        <h5 class="modal-title fw-bold" id="registerModalLabel">
          <i class="bi bi-person-plus me-2"></i> Create Your Account
        </h5>
        <!-- Top-right close -->
       <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>


      </div>

      <!-- Modal Body -->
      <div class="modal-body p-5">

        <!-- Title -->
        <div class="text-center mb-4">
          <h4 class="fw-bold text-success">Join Kerala Tourism</h4>
          <p class="text-muted">Register to explore districts, book hotels, and discover tourist spots!</p>
        </div>

        <!-- Registration Form -->
        <form action="register_submit.php" method="post" class="row g-3">
          <div class="col-md-6">
            <label class="form-label fw-semibold"><i class="bi bi-person"></i> First Name</label>
            <input type="text" class="form-control rounded-pill" name="first_name" required>
          </div>

          <div class="col-md-6">
            <label class="form-label fw-semibold"><i class="bi bi-person"></i> Last Name</label>
            <input type="text" class="form-control rounded-pill" name="last_name" required>
          </div>

          <div class="col-md-6">
            <label class="form-label fw-semibold"><i class="bi bi-envelope"></i> Email</label>
            <input type="email" class="form-control rounded-pill" name="email" required>
          </div>

          <div class="col-md-6">
            <label class="form-label fw-semibold"><i class="bi bi-telephone"></i> Mobile</label>
            <input type="text" class="form-control rounded-pill" name="phone" required>
          </div>

          <div class="col-md-6">
            <label class="form-label fw-semibold"><i class="bi bi-person-badge"></i> Username</label>
            <input type="text" class="form-control rounded-pill" name="username" required>
          </div>

          <div class="col-md-6">
            <label class="form-label fw-semibold"><i class="bi bi-lock"></i> Password</label>
            <input type="password" class="form-control rounded-pill" name="password" required>
          </div>

          <!-- Submit Button -->
          <div class="col-12 d-grid mt-4">
            <button type="submit" class="btn btn-success btn-lg rounded-pill shadow-sm">
              <i class="bi bi-check-circle me-2"></i> Register Now
            </button>
          </div>
        </form>

        <!-- Footer --> <div class="text-center mt-4"> <p class="mb-2">Already have an account? <a href="#loginModal" class="fw-bold text-success" data-bs-toggle="modal" data-bs-dismiss="modal">Login here</a> </p> <!-- Bottom Close Button --> <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal"> <i class="bi bi-x-circle me-1"></i> Close </button> </div>

      </div>
    </div>
  </div>
</div>
