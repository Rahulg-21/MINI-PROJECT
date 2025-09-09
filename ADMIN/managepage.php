<?php
include '../CONFIG/config.php';
$selectedCategory = isset($_GET['category']) ? $_GET['category'] : "";

if ($selectedCategory) {
    $stmt = $conn->prepare("SELECT * FROM pages WHERE category = ? ORDER BY id DESC");
    $stmt->bind_param("s", $selectedCategory);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $conn->query("SELECT * FROM pages ORDER BY id DESC");
}
?>
<?php include 'components/head.php'; ?>
<?php include 'components/navbar.php'; ?>

<style>
/* Default padding (for large screens with sidebar) */
.content-wrapper {
    padding-top: 80px;
    padding-left: 270px;
    padding-right: 20px;
}

/* Tablet screens */
@media (max-width: 991px) {
    .content-wrapper {
        padding-left: 200px;
        padding-right: 15px;
    }
}

/* Mobile screens */
@media (max-width: 767px) {
    .content-wrapper {
        padding-left: 15px;
        padding-right: 15px;
    }
}
</style>

<div class="content-wrapper">

<h3 class="mb-4">Manage Pages</h3>

<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Category</th>
                <th>Title</th>
                <th>Image</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php if ($result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['category'] ?></td>
                <td><?= $row['title'] ?></td>
                <td><img src="uploads/pages/<?= $row['image'] ?>" width="80"></td>
                <td><?= substr($row['description'],0,80) ?>...</td>
                <td>
                    <button 
                        class="btn btn-warning editBtn"
                        data-id="<?= $row['id'] ?>"
                        data-category="<?= $row['category'] ?>"
                        data-title="<?= htmlspecialchars($row['title'], ENT_QUOTES) ?>"
                        data-description="<?= htmlspecialchars($row['description'], ENT_QUOTES) ?>"
                        data-image="<?= $row['image'] ?>"
                    >Edit</button>
                    <a href="delete_page.php?id=<?= $row['id'] ?>" class="btn btn-danger" onclick="return confirm('Are you sure?');">Delete</a>
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
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="post" action="update_page.php" enctype="multipart/form-data">
        <div class="modal-header">
          <h5 class="modal-title">Edit Page</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" id="edit_id" name="id">
          <label>Category</label>
          <select id="edit_category" name="category" class="form-select mb-2">
            <option value="Activity">Activity</option>
            <option value="Culture">Culture</option>
            <option value="Wedding Destinations">Wedding Destinations</option>
            <option value="Souvenir">Souvenir</option>
            <option value="Food">Food</option>
          </select>
          <label>Title</label>
          <input id="edit_title" type="text" name="title" class="form-control mb-2">
          <label>Image</label><br>
          <img id="current_image" width="100" height="70" class="mb-2"><br>
          <input type="file" name="image" class="form-control mb-2">
          <label>Description</label>
          <textarea id="edit_description" name="description" class="form-control" rows="4"></textarea>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Save</button>
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
