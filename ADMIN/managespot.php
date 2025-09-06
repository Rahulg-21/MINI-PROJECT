<?php
include '../CONFIG/config.php';

// Enable error reporting for debugging 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'components/head.php'; 

// Get selected district (if any)
$selectedDistrict = isset($_GET['district_id']) ? $_GET['district_id'] : "";

// Fetch districts for dropdown
$districts = $conn->query("SELECT id, name FROM districts ORDER BY name ASC");

// Fetch tourist spots
if ($selectedDistrict) {
    $stmt = $conn->prepare("SELECT ts.*, d.name as district_name 
                            FROM tourist_spots ts 
                            JOIN districts d ON ts.district_id = d.id 
                            WHERE ts.district_id = ? ORDER BY ts.id DESC");
    $stmt->bind_param("i", $selectedDistrict);
    $stmt->execute();
    $result = $stmt->get_result();

    // Get district name separately (so we don’t consume $result rows)
    $stmtName = $conn->prepare("SELECT name FROM districts WHERE id = ?");
    $stmtName->bind_param("i", $selectedDistrict);
    $stmtName->execute();
    $districtRow = $stmtName->get_result()->fetch_assoc();
    $districtName = $districtRow ? $districtRow['name'] : "";
} else {
    $result = $conn->query("SELECT ts.*, d.name as district_name 
                            FROM tourist_spots ts 
                            JOIN districts d ON ts.district_id = d.id 
                            ORDER BY ts.id DESC");
    $districtName = "";
}
?>

<body>
<div class="page-container">
    <div class="left-content">

        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Home</a>
                <i class="fa fa-angle-right"></i> Manage Tourist Spots
            </li>
        </ol>

<!-- District Filter -->
<div class="container mt-3 mb-4">
    <form method="GET" class="form-inline">
        <label class="mr-2 font-weight-bold">Select District:</label>
        <select name="district_id" class="form-control mr-2" onchange="this.form.submit()">
            <option value="">*** All Districts ***</option>
            <?php while ($d = $districts->fetch_assoc()): ?>
                <option value="<?= $d['id'] ?>" <?= $selectedDistrict==$d['id'] ? "selected" : "" ?>>
                    <?= htmlspecialchars($d['name']) ?>
                </option>
            <?php endwhile; ?>
        </select>
        <?php if ($selectedDistrict): ?>
            <a href="managespot.php" class="btn btn-secondary btn-sm">Reset</a>
        <?php endif; ?>
    </form>
</div>

<!-- Tourist Spots Table -->
<div class="container mt-4">
    <h3>Tourist Spots <?= $districtName ? " - " . htmlspecialchars($districtName) : "" ?></h3>
    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>District</th>
                <th>Name</th>
                <th>Image</th>
                <th>Description</th>
                <th width="180">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            if ($result && $result->num_rows > 0) {
                while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= htmlspecialchars($row['district_name']) ?></td>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td>
                        <img src="uploads/tourist_spots/<?= htmlspecialchars($row['image']) ?>" width="80" height="60" style="object-fit:cover;">
                    </td>
                    <td><?= htmlspecialchars(substr($row['description'], 0, 80)) ?>...</td>
                    <td>
                        <!-- Edit Button -->
                        <button 
                            class="btn btn-warning btn-sm editBtn"
                            data-id="<?= $row['id'] ?>"
                            data-district="<?= $row['district_id'] ?>"
                            data-name="<?= htmlspecialchars($row['name'], ENT_QUOTES) ?>"
                            data-description="<?= htmlspecialchars($row['description'], ENT_QUOTES) ?>"
                            data-image="<?= $row['image'] ?>"
                            data-toggle="modal"
                            data-target="#editModal"
                        >Edit</button>

                        <!-- Delete Button -->
                        <a href="delete_tourist_spot.php?id=<?= $row['id'] ?>" 
                           class="btn btn-danger btn-sm"
                           onclick="return confirm('Are you sure you want to delete this tourist spot?');">
                           Delete
                        </a>
                    </td>
                </tr>
            <?php endwhile; } else { ?>
                <tr>
                    <td colspan="6" class="text-center">No tourist spots found.</td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <form method="post" action="update_tourist_spot.php" enctype="multipart/form-data">
        <div class="modal-header">
          <h5 class="modal-title">Edit Tourist Spot</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <div class="modal-body">
            <input type="hidden" name="id" id="edit_id">

            <!-- District -->
            <div class="form-group">
                <label>District</label>
                <select name="district_id" id="edit_district" class="form-control" required>
                    <?php 
                    $districts2 = $conn->query("SELECT id, name FROM districts ORDER BY name ASC");
                    while ($d = $districts2->fetch_assoc()): ?>
                        <option value="<?= $d['id'] ?>"><?= htmlspecialchars($d['name']) ?></option>
                    <?php endwhile; ?>
                </select>
            </div>

            <!-- Name -->
            <div class="form-group">
                <label>Tourist Spot Name</label>
                <input type="text" name="name" id="edit_name" class="form-control" required>
            </div>

            <!-- Image -->
            <div class="form-group">
                <label>Image</label><br>
                <img id="current_image" src="" alt="Current" width="100" height="70" style="object-fit:cover;"><br><br>
                <input type="file" name="image" class="form-control">
                <small>Leave blank to keep existing image</small>
            </div>

            <!-- Description -->
            <div class="form-group">
                <label>Description</label>
                <textarea name="description" id="edit_description" rows="5" class="form-control" required></textarea>
            </div>
        </div>
        
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Save Changes</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>

      </form>
    </div>
  </div>
</div>

<!-- Script to Fill Modal -->
<script>
document.addEventListener("DOMContentLoaded", function(){
    const editBtns = document.querySelectorAll(".editBtn");
    editBtns.forEach(btn => {
        btn.addEventListener("click", function(){
            document.getElementById("edit_id").value = this.dataset.id;
            document.getElementById("edit_district").value = this.dataset.district;
            document.getElementById("edit_name").value = this.dataset.name;
            document.getElementById("edit_description").value = this.dataset.description;
            document.getElementById("current_image").src = "uploads/tourist_spots/" + this.dataset.image;
        });
    });
});
</script>

<div class="inner-block"></div>
<div class="copyrights">
    <p>Kerala Tourism. All Rights Reserved | <a href="#">Kerala Tourism</a></p>
</div>
</div>
</div>

<?php include 'components/navbar.php'; ?>
</body>
</html>
