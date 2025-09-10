<?php
session_start();
include '../CONFIG/config.php';
include 'components/head.php';
include 'components/navbar.php';

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// ✅ Handle Delete Request
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    $stmt = $conn->prepare("DELETE FROM bookings WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $delete_id, $user_id);
    $stmt->execute();
    $stmt->close();
    header("Location: viewBooking.php?msg=deleted");
    exit();
}

// ✅ Handle Update Request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_booking'])) {
    $booking_id = intval($_POST['booking_id']);
    $new_date = $_POST['visit_date'];
    $new_time = $_POST['visit_time'];

    // Validation → no past datetime
    if (strtotime($new_date . ' ' . $new_time) < time()) {
        $error_message = "Invalid date/time. Please select a future time.";
    } else {
        $stmt = $conn->prepare("UPDATE bookings SET visit_date=?, visit_time=? WHERE id=? AND user_id=?");
        $stmt->bind_param("ssii", $new_date, $new_time, $booking_id, $user_id);
        if ($stmt->execute()) {
            $success_message = "Booking updated successfully!";
        } else {
            $error_message = "Failed to update booking.";
        }
        $stmt->close();
    }
}

// ✅ Fetch user bookings with JOIN
$stmt = $conn->prepare("SELECT b.*, d.name AS district_name, s.name AS spot_name
                        FROM bookings b
                        JOIN districts d ON b.district_id = d.id
                        JOIN tourist_spots s ON b.spot_id = s.id
                        WHERE b.user_id = ?
                        ORDER BY b.created_at DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
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
    <h3 class="mb-4">My Bookings</h3>

    <?php if (!empty($success_message)): ?>
        <div class="alert alert-success"><?= $success_message ?></div>
    <?php endif; ?>
    <?php if (!empty($error_message)): ?>
        <div class="alert alert-danger"><?= $error_message ?></div>
    <?php endif; ?>
    <?php if (isset($_GET['msg']) && $_GET['msg'] === 'deleted'): ?>
        <div class="alert alert-warning">Booking deleted successfully.</div>
    <?php endif; ?>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>District</th>
                    <th>Spot</th>
                    <th>Visit Date</th>
                    <th>Visit Time</th>
                    
                    <th>Planned At</th>
                    <th width="180">Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= htmlspecialchars($row['district_name']) ?></td>
                        <td><?= htmlspecialchars($row['spot_name']) ?></td>
                        <td><?= htmlspecialchars($row['visit_date']) ?></td>
                        <td><?= htmlspecialchars($row['visit_time']) ?></td>
                        
                        <td><?= htmlspecialchars($row['created_at']) ?></td>
                        <td>
                            <button class="btn btn-warning btn-sm editBtn"
                                data-id="<?= $row['id'] ?>"
                                data-date="<?= $row['visit_date'] ?>"
                                data-time="<?= $row['visit_time'] ?>"
                            >Update</button>
                            <a href="viewBooking.php?delete_id=<?= $row['id'] ?>"
                               class="btn btn-danger btn-sm"
                               onclick="return confirm('Are you sure you want to delete this booking?');">
                               Delete
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="8" class="text-center">No bookings found.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Update Modal -->
<div class="modal fade" id="updateModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="post">
        <div class="modal-header">
          <h5 class="modal-title">Update Booking</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" id="edit_booking_id" name="booking_id">
          <div class="form-group mb-3">
            <label>Date</label>
            <input type="date" id="edit_date" name="visit_date" class="form-control" required min="<?= date('Y-m-d') ?>">
          </div>
          <div class="form-group mb-3">
            <label>Time</label>
            <input type="time" id="edit_time" name="visit_time" class="form-control" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" name="update_booking" class="btn btn-primary">Save Changes</button>
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
    const updateModalEl = document.getElementById("updateModal");
    const updateModal = new bootstrap.Modal(updateModalEl);

    editBtns.forEach(btn => {
        btn.addEventListener("click", function() {
            document.getElementById("edit_booking_id").value = this.dataset.id;
            document.getElementById("edit_date").value = this.dataset.date;
            document.getElementById("edit_time").value = this.dataset.time;
            updateModal.show();
        });
    });
});
</script>

</body>
</html>
