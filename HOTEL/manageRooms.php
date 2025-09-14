<?php
session_start();
include '../CONFIG/config.php';
include 'components/head.php';
include 'components/navbar.php';

// ✅ Ensure hotel owner is logged in
if (!isset($_SESSION['hotel_id'])) {
    echo "<script>alert('Login first'); window.location='login.php';</script>";
    exit();
}

$hotel_id = $_SESSION['hotel_id'];

// Handle delete
if (isset($_GET['delete'])) {
    $room_id = intval($_GET['delete']);
    $delete_query = $conn->prepare("DELETE FROM hotel_rooms WHERE id=? AND hotel_id=?");
    $delete_query->bind_param("ii", $room_id, $hotel_id);
    if ($delete_query->execute()) {
        echo "<script>alert('Room deleted successfully'); window.location='manageRooms.php';</script>";
    } else {
        echo "<script>alert('Error deleting room');</script>";
    }
}

// Handle edit submission
if (isset($_POST['edit_submit'])) {
    $id = intval($_POST['id']);
    $room_type = mysqli_real_escape_string($conn, $_POST['room_type']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price = floatval($_POST['price']);
    $total_rooms = intval($_POST['total_rooms']);
    $available_rooms = intval($_POST['available_rooms']);

    $update_query = $conn->prepare("UPDATE hotel_rooms 
                                    SET room_type=?, description=?, price=?, total_rooms=?, available_rooms=?
                                    WHERE id=? AND hotel_id=?");
    $update_query->bind_param("ssdiiii", $room_type, $description, $price, $total_rooms, $available_rooms, $id, $hotel_id);
    if ($update_query->execute()) {
        echo "<script>alert('Room updated successfully'); window.location='manageRooms.php';</script>";
    } else {
        echo "<script>alert('Error updating room');</script>";
    }
}

// Fetch hotel rooms
$stmt = $conn->prepare("SELECT * FROM hotel_rooms WHERE hotel_id=? ORDER BY id DESC");
$stmt->bind_param("i", $hotel_id);
$stmt->execute();
$rooms_result = $stmt->get_result();
?>

<div class="content-wrapper" style="padding-top:80px; padding-left:270px; padding-right:20px;">

<h3 class="mb-4">Manage Your Hotel Rooms</h3>

<!-- Rooms Table -->
<div class="table-responsive">
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Room Type</th>
                <th>Description</th>
                <th>Price (₹)</th>
                <th>Total Rooms</th>
                <th>Available Rooms</th>
                <th width="180">Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php if ($rooms_result->num_rows > 0): ?>
            <?php while($row = $rooms_result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= htmlspecialchars($row['room_type']) ?></td>
                <td><?= htmlspecialchars(substr($row['description'], 0, 80)) ?>...</td>
                <td><?= $row['price'] ?></td>
                <td><?= $row['total_rooms'] ?></td>
                <td><?= $row['available_rooms'] ?></td>
                <td>
                    <button 
                        class="btn btn-warning btn-sm editBtn"
                        data-id="<?= $row['id'] ?>"
                        data-room_type="<?= htmlspecialchars($row['room_type'], ENT_QUOTES) ?>"
                        data-description="<?= htmlspecialchars($row['description'], ENT_QUOTES) ?>"
                        data-price="<?= $row['price'] ?>"
                        data-total_rooms="<?= $row['total_rooms'] ?>"
                        data-available_rooms="<?= $row['available_rooms'] ?>"
                    >Edit</button>
                    <a href="manage_rooms.php?delete=<?= $row['id'] ?>" 
                       class="btn btn-danger btn-sm"
                       onclick="return confirm('Are you sure you want to delete this room?');">
                       Delete
                    </a>
                </td>
            </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="7" class="text-center">No rooms found.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form method="post">
        <div class="modal-header">
          <h5 class="modal-title">Edit Room</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" id="edit_id" name="id">

          <label>Room Type</label>
          <input id="edit_room_type" type="text" name="room_type" class="form-control mb-2" required>

          <label>Description</label>
          <textarea id="edit_description" name="description" class="form-control mb-2" rows="4"></textarea>

          <label>Price (₹)</label>
          <input id="edit_price" type="number" name="price" class="form-control mb-2" step="0.01" required>

          <label>Total Rooms</label>
          <input id="edit_total_rooms" type="number" name="total_rooms" class="form-control mb-2" required>

          <label>Available Rooms</label>
          <input id="edit_available_rooms" type="number" name="available_rooms" class="form-control mb-2">
        </div>
        <div class="modal-footer">
          <button type="submit" name="edit_submit" class="btn btn-primary">Save Changes</button>
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
            document.getElementById("edit_room_type").value = this.dataset.room_type;
            document.getElementById("edit_description").value = this.dataset.description;
            document.getElementById("edit_price").value = this.dataset.price;
            document.getElementById("edit_total_rooms").value = this.dataset.total_rooms;
            document.getElementById("edit_available_rooms").value = this.dataset.available_rooms;
            editModal.show();
        });
    });
});
</script>

</div>
</body>
</html>
