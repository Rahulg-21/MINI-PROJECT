<?php
session_start();
include '../CONFIG/config.php';
include 'components/head.php';
include 'components/navbar.php';

// ✅ Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// ✅ Fetch user's guide bookings
$stmt = $conn->prepare("SELECT gb.*, g.first_name, g.last_name, g.mobile, g.email
                        FROM guide_bookings gb
                        JOIN guides g ON gb.guide_id = g.id
                        WHERE gb.user_id = ?
                        ORDER BY gb.created_at DESC");
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
    .content-wrapper { padding-left: 200px; padding-right: 15px; }
}
@media (max-width: 767px) {
    .content-wrapper { padding-left: 15px; padding-right: 15px; }
}
.badge-status {
    font-size: 0.9em;
    padding: 6px 12px;
    border-radius: 12px;
}
</style>

<div class="content-wrapper">
    <h3 class="mb-4">🎫 My Guide Bookings</h3>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Guide</th>
                    <th>Description</th>
                    <th>Booking Date</th>
                    <th>Booking Time</th>
                    <th>Status</th>
                    <th>Booked At</th>
                </tr>
            </thead>
            <tbody>
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td>
                            <strong><?= htmlspecialchars($row['first_name'] . ' ' . $row['last_name']) ?></strong><br>
                            📧 <?= htmlspecialchars($row['email']) ?><br>
                            📞 <?= htmlspecialchars($row['mobile']) ?>
                        </td>
                        <td><?= htmlspecialchars($row['description'] ?? '-') ?></td>
                        <td><?= htmlspecialchars($row['booking_date']) ?></td>
                        <td><?= htmlspecialchars($row['booking_time']) ?></td>
                        <td>
                            <?php if ($row['status'] == 'Pending'): ?>
                                <span class="badge bg-warning text-dark badge-status">⏳ Pending</span>
                            <?php elseif ($row['status'] == 'Accepted'): ?>
                                <span class="badge bg-success badge-status">✅ Accepted</span>
                            <?php else: ?>
                                <span class="badge bg-danger badge-status">❌ Rejected</span>
                            <?php endif; ?>
                        </td>
                        <td><?= htmlspecialchars($row['created_at']) ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="7" class="text-center">No guide bookings found.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
