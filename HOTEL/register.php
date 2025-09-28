<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../CONFIG/config.php';
session_start();

$message = "";

// Fetch districts
$districts = [];
$district_sql = "SELECT id, name FROM districts ORDER BY name ASC";
$district_res = mysqli_query($conn, $district_sql);
while ($row = mysqli_fetch_assoc($district_res)) {
    $districts[] = $row;
}

// Handle Form Submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $hotel_name  = mysqli_real_escape_string($conn, trim($_POST['hotel_name']));
    $email       = mysqli_real_escape_string($conn, trim($_POST['email']));
    $mobile      = mysqli_real_escape_string($conn, trim($_POST['mobile']));
    $username    = mysqli_real_escape_string($conn, trim($_POST['username']));
    $password    = mysqli_real_escape_string($conn, trim($_POST['password']));
    $district    = intval($_POST['district']);
    $spot        = intval($_POST['spot']);

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Invalid email format!";
    } else {
        // Check if email or username already exists
        $stmt = $conn->prepare("SELECT id FROM hotels WHERE email=? OR username=? LIMIT 1");
        $stmt->bind_param("ss", $email, $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $message = "Email or Username already exists!";
        } else {
            // File upload (image)
            $image = "";
            if (!empty($_FILES['image']['name'])) {
                $targetDir = __DIR__ . "/uploads/hotels/";
                if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);

                $image = time() . "_" . basename($_FILES["image"]["name"]);
                $targetFile = $targetDir . $image;

                if (!move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
                    die("❌ File upload failed. Check folder permissions.");
                }
            }

            // Hash password
            $hashed = password_hash($password, PASSWORD_BCRYPT);

            // Insert into hotels table
            $insert_sql = $conn->prepare("INSERT INTO hotels 
                (name, email, mobile, username, password, district_id, spot_id, image, status, created_at)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'Pending', NOW())");
            $insert_sql->bind_param("sssssiis", $hotel_name, $email, $mobile, $username, $hashed, $district, $spot, $image);

            if ($insert_sql->execute()) {
                echo "<script>
                        alert('Hotel registration successful! Wait for admin approval.');
                        window.location='login.php';
                      </script>";
                exit;
            } else {
                $message = "Error: " . $insert_sql->error;
            }
        }
        $stmt->close();
    }
}
?>
<?php include 'components/head.php'; ?>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
  <div class="container">
    <a class="navbar-brand fw-bold text-success" href="index.php">
      <i class="bi bi-building"></i> Kerala Tourism - Hotels
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        
       <!-- <li class="nav-item"><a class="nav-link text-success fw-semibold" href="login.php">Login</a></li>-->
      </ul>
    </div>
  </div>
</nav>

<div class="container my-5">
  <div class="row justify-content-center">
    <div class="col-lg-6 col-md-8">
      <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
        <div class="card-header text-white" style="background: linear-gradient(90deg, #2e7d32, #66bb6a);">
          <h4 class="fw-bold mb-0"><i class="bi bi-building me-2"></i> Hotel Registration</h4>
        </div>

        <div class="card-body p-5">
          <?php if ($message): ?>
            <div class="alert alert-danger"><?= $message ?></div>
          <?php endif; ?>

          <form method="post" enctype="multipart/form-data" class="row g-3">
            <div class="col-12">
              <label class="form-label fw-semibold">Hotel Name</label>
              <input type="text" name="hotel_name" class="form-control rounded-pill" required>
            </div>
            <div class="col-12">
              <label class="form-label fw-semibold">Email</label>
              <input type="email" name="email" class="form-control rounded-pill" required>
            </div>
            <div class="col-12">
              <label class="form-label fw-semibold">Mobile</label>
              <input type="text" name="mobile" class="form-control rounded-pill" required>
            </div>
            <div class="col-12">
              <label class="form-label fw-semibold">Username</label>
              <input type="text" name="username" class="form-control rounded-pill" required>
            </div>
            <div class="col-12">
              <label class="form-label fw-semibold">Password</label>
              <input type="password" name="password" class="form-control rounded-pill" required>
            </div>
            <div class="col-12">
              <label class="form-label fw-semibold">District</label>
              <select name="district" id="district" class="form-control rounded-pill" required>
                <option value="">-- Select District --</option>
                <?php foreach($districts as $d): ?>
                  <option value="<?= $d['id'] ?>"><?= $d['name'] ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-12">
              <label class="form-label fw-semibold">Nearby Tourist Spot</label>
              <select name="spot" id="spot" class="form-control rounded-pill" required>
                <option value="">-- Select Tourist Spot --</option>
              </select>
            </div>
            <div class="col-12">
              <label class="form-label fw-semibold">Hotel Image</label>
              <input type="file" name="image" class="form-control rounded-pill" accept="image/*" required>
            </div>
            <div class="col-12 d-grid mt-4">
              <button type="submit" class="btn btn-success btn-lg rounded-pill shadow-sm">Register Hotel</button>
            </div>
          </form>
          <div class="text-center mt-3">
            <p class="mb-0">Alraedy have an account? 
              <a href="login.php" class="fw-bold text-success">Login</a>
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Footer -->
<footer class="bg-light text-center py-3 mt-5 border-top">
  <div class="container">
    <p class="mb-0 text-muted">&copy; <?= date('Y') ?> Kerala Tourism Hotels. All Rights Reserved.</p>
  </div>
</footer>

<!-- AJAX: Load tourist spots based on district -->
<script>
document.getElementById("district").addEventListener("change", function() {
  var districtId = this.value;
  var spotSelect = document.getElementById("spot");

  fetch("load_spots.php?district_id=" + districtId)
    .then(res => res.json())
    .then(data => {
      spotSelect.innerHTML = "<option value=''>-- Select Tourist Spot --</option>";
      data.forEach(s => {
        spotSelect.innerHTML += `<option value="${s.id}">${s.name}</option>`;
      });
    });
});
</script>
</body>
</html>
