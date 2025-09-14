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

// ✅ Handle delete booking
if (isset($_GET['delete'])) {
    $booking_id = intval($_GET['delete']);
    $stmt = $conn->prepare("DELETE FROM hotel_bookings WHERE id=? AND hotel_id=?");
    $stmt->bind_param("ii", $booking_id, $hotel_id);
    if ($stmt->execute()) {
        echo "<script>alert('Booking deleted successfully'); window.location='viewBookings.php';</script>";
    } else {
        echo "<script>alert('Error deleting booking');</script>";
    }
}

// ✅ Handle approve booking
if (isset($_GET['approve'])) {
    $booking_id = intval($_GET['approve']);
    $stmt = $conn->prepare("UPDATE hotel_bookings SET status='Confirmed' WHERE id=? AND hotel_id=?");
    $stmt->bind_param("ii", $booking_id, $hotel_id);
    if ($stmt->execute()) {
        echo "<script>alert('Booking approved'); window.location='viewBookings.php';</script>";
    } else {
        echo "<script>alert('Error approving booking');</script>";
    }
}

// ✅ Fetch only pending bookings for this hotel
$stmt = $conn->prepare("
    SELECT hb.*, hr.room_type, u.username AS user_name
    FROM hotel_bookings hb
    JOIN hotel_rooms hr ON hb.room_id = hr.id
    JOIN users u ON hb.user_id = u.id
    WHERE hb.hotel_id=? AND hb.status='Pending'
    ORDER BY hb.created_at DESC
");
$stmt->bind_param("i", $hotel_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<div class="content-wrapper" style="padding-top:80px; padding-left:270px; padding-right:20px;">
<h3 class="mb-4">Hotel Room Bookings</h3>

<div class="table-responsive">
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>User</th>
                <th>Room Type</th>
                <th>Booking Date</th>
                <th>Booking Time</th>
                <th>Status</th>
                <th>Booked At</th>
                <th width="180">Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php if ($result && $result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= htmlspecialchars($row['user_name']) ?></td>
                <td><?= htmlspecialchars($row['room_type']) ?></td>
                <td><?= htmlspecialchars($row['booking_date']) ?></td>
                <td><?= htmlspecialchars($row['booking_time']) ?></td>
                <td>
                    <?php if($row['status'] == 'Pending'): ?>
                        <span class="badge bg-warning text-dark">⏳ Pending</span>
                    <?php elseif($row['status'] == 'Confirmed'): ?>
                        <span class="badge bg-success">✅ Confirmed</span>
                    <?php else: ?>
                        <span class="badge bg-danger">❌ <?= htmlspecialchars($row['status']) ?></span>
                    <?php endif; ?>
                </td>
                <td><?= htmlspecialchars($row['created_at']) ?></td>
                <td>
                    <?php if($row['status'] == 'Pending'): ?>
                        <a href="?approve=<?= $row['id'] ?>" class="btn btn-success btn-sm" onclick="return confirm('Approve this booking?');">Approve</a>
                    <?php endif; ?>
                    <a href="?delete=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete this booking?');">Delete</a>
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

</body>
</html>
