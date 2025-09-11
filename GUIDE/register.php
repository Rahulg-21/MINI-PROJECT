<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../CONFIG/config.php'; // DB connection ($conn)
session_start();

$message = "";

// Fetch districts
$districts = [];
$district_sql = "SELECT id, name FROM districts ORDER BY description ASC";
$district_res = mysqli_query($conn, $district_sql);
while ($row = mysqli_fetch_assoc($district_res)) {
    $districts[] = $row;
}

// Handle Form Submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = mysqli_real_escape_string($conn, trim($_POST['first_name']));
    $last_name  = mysqli_real_escape_string($conn, trim($_POST['last_name']));
    $email      = mysqli_real_escape_string($conn, trim($_POST['email']));
    $mobile     = mysqli_real_escape_string($conn, trim($_POST['mobile']));
    $username   = mysqli_real_escape_string($conn, trim($_POST['username']));
    $password   = mysqli_real_escape_string($conn, trim($_POST['password']));
    $district   = intval($_POST['district']);
    $spot       = intval($_POST['spot']);
    $id_card    = mysqli_real_escape_string($conn, trim($_POST['id_card']));

    // File upload (image)
    $image = "";
   if (!empty($_FILES['image']['name'])) {
    $targetDir = __DIR__ . "/uploads/guides/"; // ✅ use absolute path
    if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);

    $image = time() . "_" . basename($_FILES["image"]["name"]);
    $targetFile = $targetDir . $image;

    if (!move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
        die("❌ File upload failed. Check folder permissions.");
    }
}


    // Check if email or username already exists
    $check_sql = "SELECT id FROM guides WHERE email='$email' OR username='$username' LIMIT 1";
    $check_res = mysqli_query($conn, $check_sql);

    if (mysqli_num_rows($check_res) > 0) {
        $message = "Email or Username already exists!";
    } else {
        // Hash password
        $hashed = password_hash($password, PASSWORD_BCRYPT);

        // Insert into guides table
        $insert_sql = "INSERT INTO guides 
            (first_name, last_name, email, mobile, username, password, district_id, spot_id, image, id_card, status, created_at) 
            VALUES 
            ('$first_name', '$last_name', '$email', '$mobile', '$username', '$hashed', $district, $spot, '$image', '$id_card', 'Pending', NOW())";

        if (mysqli_query($conn, $insert_sql)) {
            $message = "Registration successful! Wait for admin approval.";
            echo "<script>
                        alert('Registration successful!');
                        window.location='login.php';
                      </script>";
              
        } else {
            $message = "Error: " . mysqli_error($conn);
        }
    }
}
?>
<?php include 'components/head.php'; ?>
<body>



<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
  <div class="container">
    <a class="navbar-brand fw-bold text-success" href="index.php">
      <i class="bi bi-tree-fill"></i> Kerala Tourism
    </a>
  </div>
</nav>


<div class="container my-5">
  <div class="row justify-content-center">
    <div class="col-lg-6 col-md-8">

      <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
        <div class="card-header text-white" style="background: linear-gradient(90deg, #2e7d32, #66bb6a);">
          <h4 class="fw-bold mb-0"><i class="bi bi-person-plus me-2"></i> Guide Registration</h4>
        </div>

        <div class="card-body p-5">
          <?php if ($message): ?>
            <div class="alert alert-info"><?= $message ?></div>
          <?php endif; ?>

          <form method="post" enctype="multipart/form-data" class="row g-3">
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
            <div class="col-12">
              <label class="form-label fw-semibold"><i class="bi bi-map"></i> District</label>
              <select name="district" id="district" class="form-control rounded-pill" required>
                <option value="">-- Select District --</option>
                <?php foreach($districts as $d): ?>
                  <option value="<?= $d['id'] ?>"><?= $d['name'] ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-12">
              <label class="form-label fw-semibold"><i class="bi bi-tree"></i> Tourist Spot</label>
              <select name="spot" id="spot" class="form-control rounded-pill" required>
                <option value="">-- Select Tourist Spot --</option>
              </select>
            </div>
            <div class="col-12">
              <label class="form-label fw-semibold"><i class="bi bi-image"></i> Upload Image</label>
              <input type="file" name="image" class="form-control rounded-pill" accept="image/*" required>
            </div>
            <div class="col-12">
              <label class="form-label fw-semibold"><i class="bi bi-card-text"></i> Valid ID Card No</label>
              <input type="text" name="id_card" class="form-control rounded-pill" required>
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
<footer class="bg-light text-center py-3 mt-5 border-top">
  <div class="container">
    <p class="mb-0 text-muted">&copy; <?= date('Y') ?> Kerala Tourism. All Rights Reserved.</p>
  </div>
</footer>
</body>
</html>



<!-- Ajax: Load tourist spots based on district -->
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
