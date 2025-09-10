<?php session_start(); ?>
<!-- Bootstrap 5 Navbar -->
<nav class="navbar navbar-expand-lg navbar-light" 
     style="background: linear-gradient(90deg, #1b5e20, #388e3c, #81c784);">
  <div class="container">
    <!-- Logo -->
    <a class="navbar-brand" href="index.php">
      <img src="assets/img/kerala-tourism.png" alt="logo" height="40">
    </a>

    <!-- Mobile Toggle Button -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" 
            data-bs-target="#mainNavbar" aria-controls="mainNavbar" 
            aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Navbar Links -->
    <div class="collapse navbar-collapse" id="mainNavbar">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active text-white fw-semibold" href="index.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white fw-semibold" href="map.php">Explore</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white fw-semibold" href="emergency.php">Emergency</a>
        </li>

        <!-- Dropdown Menu -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle text-white fw-semibold" href="#" id="experienceDropdown" 
             role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Experiences
          </a>
          <ul class="dropdown-menu" aria-labelledby="experienceDropdown">
            <li><a class="dropdown-item" href="activites.php">Activities</a></li>
            <li><a class="dropdown-item" href="culture.php">Cultures</a></li>
            <li><a class="dropdown-item" href="destination.php">Wedding Destinations</a></li>
            <li><a class="dropdown-item" href="souvenirs.php">Souvenirs</a></li>
            <li><a class="dropdown-item" href="foods.php">Foods</a></li>
          </ul>
        </li>

        <li class="nav-item">
          <a class="nav-link text-white fw-semibold" href="about.php">About Us</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white fw-semibold" href="contact.php">Contact</a>
        </li>
      </ul>

      <!-- Right Side Button -->
      <?php if (isset($_SESSION['user_id'])): ?>
        <a href="../USER/index.php" class="btn btn-light ms-lg-3 fw-bold">Dashboard</a>
       
      <?php else: ?>
        <button class="btn btn-light ms-lg-3 fw-bold" data-bs-toggle="modal" data-bs-target="#loginModal">
          Register / Login
        </button>
      <?php endif; ?>

    </div>
  </div>
</nav>

<!-- Login Modal only for guests -->
<?php if (!isset($_SESSION['user_id'])): ?>
  <?php include 'components/login-modal.php'; ?>
<?php endif; ?>
