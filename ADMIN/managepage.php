<?php
include '../CONFIG/config.php';

// Enable error reporting for debugging 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'components/head.php'; ?>

<body>
<div class="page-container">
    <div class="left-content">

        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Home</a>
                <i class="fa fa-angle-right"></i> Manage Page Data
            </li>
        </ol>

      <?php


// Fetch all pages
$result = $conn->query("SELECT * FROM pages ORDER BY id DESC");
?>

<!-- Page Table -->
<div class="container mt-4">
    <h3>Pages List</h3>
    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
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
            <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['category'] ?></td>
                <td><?= $row['title'] ?></td>
                <td>
                    <img src="uploads/pages/<?= $row['image'] ?>" width="80" height="60" style="object-fit:cover;">
                </td>
                <td><?= substr($row['description'], 0, 80) ?>...</td>
                <td>
                    <!-- Edit Button -->
                    <button 
                        class="btn btn-warning btn-sm editBtn"
                        data-id="<?= $row['id'] ?>"
                        data-category="<?= $row['category'] ?>"
                        data-title="<?= htmlspecialchars($row['title'], ENT_QUOTES) ?>"
                        data-description="<?= htmlspecialchars($row['description'], ENT_QUOTES) ?>"
                        data-image="<?= $row['image'] ?>"
                        data-toggle="modal"
                        data-target="#editModal"
                    >Edit</button>

                    <!-- Delete Button -->
                    <a href="delete_page.php?id=<?= $row['id'] ?>" 
                       class="btn btn-danger btn-sm"
                       onclick="return confirm('Are you sure you want to delete this page?');">
                       Delete
                    </a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <form method="post" action="update_page.php" enctype="multipart/form-data">
        <div class="modal-header">
          <h5 class="modal-title">Edit Page</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <div class="modal-body">
            <input type="hidden" name="id" id="edit_id">

            <!-- Category -->
            <div class="form-group">
                <label>Category</label>
                <select name="category" id="edit_category" class="form-control" required>
                    <option value="Activity">Activity</option>
                    <option value="Culture">Culture</option>
                    <option value="Wedding Destinations">Wedding Destinations</option>
                    <option value="Souvenir">Souvenir</option>
                    <option value="Food">Food</option>
                </select>
            </div>

            <!-- Title -->
            <div class="form-group">
                <label>Title</label>
                <input type="text" name="title" id="edit_title" class="form-control" required>
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
            document.getElementById("edit_category").value = this.dataset.category;
            document.getElementById("edit_title").value = this.dataset.title;
            document.getElementById("edit_description").value = this.dataset.description;
            document.getElementById("current_image").src = "uploads/pages/" + this.dataset.image;
        });
    });
});
</script>


        <div class="inner-block"></div>

        <div class="copyrights">
            <p>TMS. All Rights Reserved | <a href="#">TMS</a></p>
        </div>
    </div>
</div>

<?php include 'components/navbar.php'; ?>
</body>
</html>
