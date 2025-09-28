<?php
// ✅ Only allow logged-in guide
session_start();
if(!isset($_SESSION['admin_id'])){
    echo "<script>alert('Login!'); window.location='login.php';</script>";
    exit;
} ?>


<?php
include '../CONFIG/config.php';
include 'components/head.php';
include 'components/navbar.php';

// Get selected district
$selectedDistrict = isset($_GET['district_id']) ? $_GET['district_id'] : "";

// Fetch districts
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

<style>
.content-wrapper {
    padding-top: 80px;
    padding-left: 270px;
    padding-right: 20px;
}
@media (max-width: 991px) {
    .content-wrapper {
        padding-left: 200px;
        padding-right: 15px;
    }
}
@media (max-width: 767px) {
    .content-wrapper {
        padding-left: 15px;
        padding-right: 15px;
    }
}
</style>

<div class="content-wrapper">

<h3 class="mb-4">Tourist Spots <?= $districtName ? "- " . htmlspecialchars($districtName) : "" ?></h3>

<!-- District Filter -->
<form method="GET" class="row g-3 mb-4">
    <div class="col-auto">
        <label class="col-form-label">Select District:</label>
    </div>
    <div class="col-auto">
        <select name="district_id" class="form-select" onchange="this.form.submit()">
            <option value="">*** All Districts ***</option>
            <?php while ($d = $districts->fetch_assoc()): ?>
                <option value="<?= $d['id'] ?>" <?= $selectedDistrict==$d['id'] ? "selected" : "" ?>>
                    <?= htmlspecialchars($d['name']) ?>
                </option>
            <?php endwhile; ?>
        </select>
    </div>
    <?php if ($selectedDistrict): ?>
    <div class="col-auto">
        <a href="managespot.php" class="btn btn-secondary">Reset</a>
    </div>
    <?php endif; ?>
</form>

<!-- Tourist Spots Table -->
<div class="table-responsive">
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
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
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= htmlspecialchars($row['district_name']) ?></td>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><img src="uploads/tourist_spots/<?= htmlspecialchars($row['image']) ?>" width="80" height="60" style="object-fit:cover;"></td>
                    <td><?= htmlspecialchars(substr($row['description'], 0, 80)) ?>...</td>
                    <td>
                        <button 
                            class="btn btn-warning btn-sm editBtn"
                            data-id="<?= $row['id'] ?>"
                            data-district="<?= $row['district_id'] ?>"
                            data-name="<?= htmlspecialchars($row['name'], ENT_QUOTES) ?>"
                            data-description="<?= htmlspecialchars($row['description'], ENT_QUOTES) ?>"
                            data-image="<?= $row['image'] ?>"
                        >Edit</button>
                        <a href="delete_tourist_spot.php?id=<?= $row['id'] ?>" 
                           class="btn btn-danger btn-sm"
                           onclick="return confirm('Are you sure you want to delete this tourist spot?');">
                           Delete
                        </a>
                    </td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="6" class="text-center">No tourist spots found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form method="post" action="update_tourist_spot.php" enctype="multipart/form-data">
        <div class="modal-header">
          <h5 class="modal-title">Edit Tourist Spot</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
            <input type="hidden" id="edit_id" name="id">

            <label>District</label>
            <select id="edit_district" name="district_id" class="form-select mb-2" required>
                <?php 
                $districts2 = $conn->query("SELECT id, name FROM districts ORDER BY name ASC");
                while ($d = $districts2->fetch_assoc()): ?>
                    <option value="<?= $d['id'] ?>"><?= htmlspecialchars($d['name']) ?></option>
                <?php endwhile; ?>
            </select>

            <label>Tourist Spot Name</label>
            <input id="edit_name" type="text" name="name" class="form-control mb-2" required>

            <label>Image</label><br>
            <img id="current_image" width="100" height="70" class="mb-2"><br>
            <input type="file" name="image" class="form-control mb-2">
            <small class="text-muted">Leave blank to keep existing image</small>

            <label>Description</label>
            <textarea id="edit_description" name="description" class="form-control" rows="4" required></textarea>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Save Changes</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function(){
    const editBtns = document.querySelectorAll(".editBtn");
    const editModalEl = document.getElementById("editModal");
    const editModal = new bootstrap.Modal(editModalEl);

    editBtns.forEach(btn => {
        btn.addEventListener("click", function(){
            document.getElementById("edit_id").value = this.dataset.id;
            document.getElementById("edit_district").value = this.dataset.district;
            document.getElementById("edit_name").value = this.dataset.name;
            document.getElementById("edit_description").value = this.dataset.description;
            document.getElementById("current_image").src = "uploads/tourist_spots/" + this.dataset.image;
            editModal.show();
        });
    });
});
</script>

</div>
</body>
</html>
