<?php
// Assume guide login session
session_start();
include '../CONFIG/config.php';
include 'components/head.php';
include 'components/navbar.php';

if (!isset($_SESSION['guide_id'])) {
    die("Unauthorized access. Please login as guide.");
}
$guide_id = $_SESSION['guide_id'];

// Fetch guide bookings
$query = "SELECT gb.*, u.username AS user_name
          FROM guide_bookings gb
          JOIN users u ON gb.user_id = u.id
          WHERE gb.guide_id = ?
          ORDER BY gb.id DESC";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $guide_id);
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
    <h3 class="mb-4">📅 My Bookings</h3>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Description</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Status</th>
                    <th width="200">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= htmlspecialchars($row['user_name']) ?></td>
                        <td><?= htmlspecialchars($row['description'] ?? 'N/A') ?></td>
                        <td><?= htmlspecialchars($row['booking_date']) ?></td>
                        <td><?= htmlspecialchars($row['booking_time']) ?></td>
                        <td>
                            <?php if ($row['status'] == 'Pending'): ?>
                                <span class="badge bg-warning">Pending</span>
                            <?php elseif ($row['status'] == 'Accepted'): ?>
                                <span class="badge bg-success">Accepted</span>
                            <?php else: ?>
                                <span class="badge bg-danger">Rejected</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($row['status'] == 'Pending'): ?>
                                <a href="update_booking_status.php?id=<?= $row['id'] ?>&status=Accepted" 
                                   class="btn btn-success btn-sm"
                                   onclick="return confirm('Accept this booking?');">
                                   Accept
                                </a>
                                <a href="update_booking_status.php?id=<?= $row['id'] ?>&status=Rejected" 
                                   class="btn btn-danger btn-sm"
                                   onclick="return confirm('Reject this booking?');">
                                   Reject
                                </a>
                            <?php else: ?>
                                <em>No action</em>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="7" class="text-center">No bookings found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
