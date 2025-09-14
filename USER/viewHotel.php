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

// ✅ Fetch user's hotel bookings
$stmt = $conn->prepare("
    SELECT hb.*, h.name AS hotel_name, hr.room_type, hr.price, d.name AS district_name
    FROM hotel_bookings hb
    JOIN hotels h ON hb.hotel_id = h.id
    JOIN hotel_rooms hr ON hb.room_id = hr.id
    JOIN districts d ON h.district_id = d.id
    WHERE hb.user_id = ?
    ORDER BY hb.created_at DESC
");
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
    <h3 class="mb-4">🏨 My Hotel Bookings</h3>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Hotel</th>
                    <th>Room Type</th>
                    <th>Price (₹)</th>
                    <th>District</th>
                    <th>Booking Date</th>
                    <th>Booking Time</th>
                    <th>Booked At</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= htmlspecialchars($row['hotel_name']) ?></td>
                        <td><?= htmlspecialchars($row['room_type']) ?></td>
                        <td><?= number_format($row['price'], 2) ?></td>
                        <td><?= htmlspecialchars($row['district_name']) ?></td>
                        <td><?= htmlspecialchars($row['booking_date']) ?></td>
                        <td><?= htmlspecialchars($row['booking_time']) ?></td>
                        <td><?= htmlspecialchars($row['created_at']) ?></td>
                        <td>
                            <?php if ($row['status'] == 'Pending'): ?>
                                <span class="badge bg-warning text-dark badge-status">⏳ Pending</span>
                            <?php elseif ($row['status'] == 'Confirmed'): ?>
                                <span class="badge bg-success badge-status">✅ Confirmed</span>
                            <?php elseif ($row['status'] == 'Cancelled'): ?>
                                <span class="badge bg-danger badge-status">❌ Cancelled</span>
                            <?php else: ?>
                                <span class="badge bg-secondary badge-status"><?= htmlspecialchars($row['status']) ?></span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="9" class="text-center">No hotel bookings found.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
