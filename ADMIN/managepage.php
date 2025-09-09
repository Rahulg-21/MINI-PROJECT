<?php
include '../CONFIG/config.php';
include 'components/head.php';
include 'components/navbar.php';

// Selected category
$selectedCategory = isset($_GET['category']) ? $_GET['category'] : "";

// Fetch pages based on filter
if ($selectedCategory) {
    $stmt = $conn->prepare("SELECT * FROM pages WHERE category = ? ORDER BY id DESC");
    $stmt->bind_param("s", $selectedCategory);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $conn->query("SELECT * FROM pages ORDER BY id DESC");
}
?>

<style>
/* Layout spacing for sidebar */
.content-wrapper {
    padding-top: 80px;
    padding-left: 270px;
    padding-right: 20px;
}
@media (max-width: 991px) {
    .content-wrapper { padding-left: 200px; padding-right: 15px; }
}
@media (max-width: 767px) {
    .content-wrapper { padding-left: 15px; padding-right: 15px; }
}
</style>

<div class="content-wrapper">

<h3 class="mb-4">Manage Pages <?= $selectedCategory ? "- " . htmlspecialchars($selectedCategory) : "" ?></h3>

<!-- Category Filter -->
<form method="GET" class="row g-3 mb-4">
    <div class="col-auto">
        <label class="col-form-label">Select Category:</label>
    </div>
    <div class="col-auto">
        <select name="category" class="form-select" onchange="this.form.submit()">
            <option value="">*** All Categories ***</option>
            <option value="Activity" <?= $selectedCategory=="Activity" ? "selected" : "" ?>>Activity</option>
            <option value="Culture" <?= $selectedCategory=="Culture" ? "selected" : "" ?>>Culture</option>
            <option value="Wedding Destinations" <?= $selectedCategory=="Wedding Destinations" ? "selected" : "" ?>>Wedding Destinations</option>
            <option value="Souvenir" <?= $selectedCategory=="Souvenir" ? "selected" : "" ?>>Souvenir</option>
            <option value="Food" <?= $selectedCategory=="Food" ? "selected" : "" ?>>Food</option>
        </select>
    </div>
    <?php if ($selectedCategory): ?>
    <div class="col-auto">
        <a href="managepage.php" class="btn btn-secondary">Reset</a>
    </div>
    <?php endif; ?>
</form>

<!-- Pages Table -->
<div class="table-responsive">
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Category</th>
                <th>Title</th>
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
                <td><?= htmlspecialchars($row['category']) ?></td>
                <td><?= htmlspecialchars($row['title']) ?></td>
                <td><img src="uploads/pages/<?= htmlspecialchars($row['image']) ?>" width="80" height="60" style="object-fit:cover;"></td>
                <td><?= htmlspecialchars(substr($row['description'], 0, 80)) ?>...</td>
                <td>
                    <button 
                        class="btn btn-warning btn-sm editBtn"
                        data-id="<?= $row['id'] ?>"
                        data-category="<?= htmlspecialchars($row['category'], ENT_QUOTES) ?>"
                        data-title="<?= htmlspecialchars($row['title'], ENT_QUOTES) ?>"
                        data-description="<?= htmlspecialchars($row['description'], ENT_QUOTES) ?>"
                        data-image="<?= $row['image'] ?>"
                    >Edit</button>
                    <a href="delete_page.php?id=<?= $row['id'] ?>" 
                       class="btn btn-danger btn-sm"
                       onclick="return confirm('Are you sure you want to delete this page?');">
                       Delete
                    </a>
                </td>
            </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="6" class="text-center">No pages found.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form method="post" action="update_page.php" enctype="multipart/form-data">
        <div class="modal-header">
          <h5 class="modal-title">Edit Page</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" id="edit_id" name="id">

          <label>Category</label>
          <select id="edit_category" name="category" class="form-select mb-2" required>
              <option value="Activity">Activity</option>
              <option value="Culture">Culture</option>
              <option value="Wedding Destinations">Wedding Destinations</option>
              <option value="Souvenir">Souvenir</option>
              <option value="Food">Food</option>
          </select>

          <label>Title</label>
          <input id="edit_title" type="text" name="title" class="form-control mb-2" required>

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
document.addEventListener("DOMContentLoaded", function() {
    const editBtns = document.querySelectorAll(".editBtn");
    const editModalEl = document.getElementById("editModal");
    const editModal = new bootstrap.Modal(editModalEl);

    editBtns.forEach(btn => {
        btn.addEventListener("click", function() {
            document.getElementById("edit_id").value = this.dataset.id;
            document.getElementById("edit_category").value = this.dataset.category;
            document.getElementById("edit_title").value = this.dataset.title;
            document.getElementById("edit_description").value = this.dataset.description;
            document.getElementById("current_image").src = "uploads/pages/" + this.dataset.image;
            editModal.show();
        });
    });
});
</script>

</div>
</body>
</html>
