<?php 
include 'components/head.php'; 
include '../CONFIG/config.php';

// Enable error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Fetch districts for dropdown
$districts = mysqli_query($conn, "SELECT id, name FROM districts");

// Handle filters
$selectedDistrict = isset($_GET['district']) ? intval($_GET['district']) : 0;
$selectedType = isset($_GET['type']) ? $_GET['type'] : '';

$query = "SELECT es.*, d.name as district_name 
          FROM emergency_services es 
          JOIN districts d ON es.district_id = d.id WHERE 1";

if ($selectedDistrict > 0) {
    $query .= " AND es.district_id = $selectedDistrict";
}
if (!empty($selectedType)) {
    $query .= " AND es.type = '" . mysqli_real_escape_string($conn, $selectedType) . "'";
}

$result = mysqli_query($conn, $query);
?>

<body>
<?php include 'components/pre-loader.php'; ?>
<header class="main_header_arae"></header>
<?php include 'components/navbar.php'; ?>

<div class="container-fluid mt-4">
  <div class="row">

    <!-- Sidebar Filter -->
    <div class="col-lg-3 col-md-4 mb-3">
      <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
          <h5 class="mb-0">Filter Emergency Services</h5>
        </div>
        <div class="card-body">
          <form method="GET" action="">
            <div class="mb-3">
              <label class="form-label">Select District</label>
              <select name="district" class="form-select">
                <option value="">All Districts</option>
                <?php while ($d = mysqli_fetch_assoc($districts)) { ?>
                  <option value="<?php echo $d['id']; ?>" <?php if($selectedDistrict==$d['id']) echo 'selected'; ?>>
                    <?php echo $d['name']; ?>
                  </option>
                <?php } ?>
              </select>
            </div>

            <div class="mb-3">
              <label class="form-label">Type of Service</label>
              <select name="type" class="form-select">
                <option value="">All Types</option>
                <option value="Hospital" <?php if($selectedType=='Hospital') echo 'selected'; ?>>Hospital</option>
                <option value="Fire & Rescue" <?php if($selectedType=='Fire & Rescue') echo 'selected'; ?>>Fire & Rescue</option>
                <option value="Ham Radio" <?php if($selectedType=='Ham Radio') echo 'selected'; ?>>Ham Radio</option>
                <option value="Elephant Squad" <?php if($selectedType=='Elephant Squad') echo 'selected'; ?>>Elephant Squad</option>
                <option value="Police" <?php if($selectedType=='Police') echo 'selected'; ?>>Police</option>
                <option value="Ambulance" <?php if($selectedType=='Ambulance') echo 'selected'; ?>>Ambulance</option>
                <option value="Coast Guard" <?php if($selectedType=='Coast Guard') echo 'selected'; ?>>Coast Guard</option>
              </select>
            </div>

            <button type="submit" class="btn btn-primary w-100">Apply Filter</button>
          </form>
        </div>
      </div>
    </div>

    <!-- Content Area -->
    <div class="col-lg-9 col-md-8">
      <h2 class="mb-4">Emergency Information</h2>
      <div class="row">
        <?php if (mysqli_num_rows($result) > 0) {
          while ($row = mysqli_fetch_assoc($result)) {
            $imagePath = !empty($row['image']) ? "../ADMIN/uploads/emergency/" . htmlspecialchars($row['image']) : "assets/img/default.jpg";
        ?>
          <div class="col-lg-6 col-md-12 mb-4">
            <div class="card h-100 shadow-sm">
              <img src="<?php echo $imagePath; ?>" class="card-img-top" alt="<?php echo htmlspecialchars($row['name']); ?>" style="height:200px; object-fit:cover;">
              <div class="card-body">
                <h5 class="card-title"><?php echo htmlspecialchars($row['name']); ?></h5>
                <p class="card-text">
                  <strong>District:</strong> <?php echo $row['district_name']; ?><br>
                  <strong>Type:</strong> <?php echo $row['type']; ?><br>
                  <strong>Contact:</strong> <?php echo htmlspecialchars($row['contact']); ?><br>
                  <strong>Address:</strong> <?php echo htmlspecialchars($row['address']); ?><br>
                </p>
                <p><?php echo nl2br(htmlspecialchars($row['description'])); ?></p>
              </div>
            </div>
          </div>
        <?php }} else { ?>
          <div class="col-12">
            <div class="alert alert-warning">No emergency services found.</div>
          </div>
        <?php } ?>
      </div>
    </div>

  </div>
</div>

<?php include 'components/footer.php'; ?>
