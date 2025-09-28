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

// Handle Approve or Delete actions
if (isset($_GET['action']) && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    if ($_GET['action'] === 'approve') {
        // Approve hotel
        $stmt = $conn->prepare("UPDATE hotels SET status='Approved' WHERE id=?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            echo "<script>alert('Hotel approved successfully!'); window.location='approveHotel.php';</script>";
        }
        $stmt->close();
    } elseif ($_GET['action'] === 'delete') {
        // Delete hotel
        // Optional: delete uploaded image file
        $img_res = $conn->query("SELECT image FROM hotels WHERE id=$id LIMIT 1");
        if ($img_res && $img_res->num_rows > 0) {
            $row = $img_res->fetch_assoc();
            if (!empty($row['image']) && file_exists("../HOTEL/uploads/hotels/".$row['image'])) {
                unlink("../HOTEL/uploads/hotels/".$row['image']);
            }
        }

        $stmt = $conn->prepare("DELETE FROM hotels WHERE id=?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            echo "<script>alert('Hotel deleted successfully!'); window.location='approveHotel.php';</script>";
        }
        $stmt->close();
    }
}

// Fetch pending hotels
$result = $conn->query("SELECT h.*, d.name as district_name, t.name as spot_name 
                        FROM hotels h
                        LEFT JOIN districts d ON h.district_id = d.id
                        LEFT JOIN tourist_spots t ON h.spot_id = t.id
                        WHERE h.status = 'Pending'
                        ORDER BY h.id DESC");
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
</style>

<div class="content-wrapper">
    <h3 class="mb-4">⏳ Pending Hotels</h3>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Hotel Name</th>
                    <th>Email</th>
                    <th>Mobile</th>
                    <th>District</th>
                    <th>Tourist Spot</th>
                    <th>Image</th>
                    <th>Status</th>
                    <th width="200">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= htmlspecialchars($row['name']) ?></td>
                        <td><?= htmlspecialchars($row['email']) ?></td>
                        <td><?= htmlspecialchars($row['mobile']) ?></td>
                        <td><?= htmlspecialchars($row['district_name']) ?></td>
                        <td><?= htmlspecialchars($row['spot_name']) ?></td>
                        <td>
                            <?php if(!empty($row['image'])): ?>
                                <img src="../HOTEL/uploads/hotels/<?= htmlspecialchars($row['image']) ?>" width="80" height="60" style="object-fit:cover;">
                            <?php else: ?>
                                <span class="text-muted">No image</span>
                            <?php endif; ?>
                        </td>
                        <td><?= htmlspecialchars($row['status']) ?></td>
                        <td>
                            <a href="?action=approve&id=<?= $row['id'] ?>" 
                               class="btn btn-success btn-sm"
                               onclick="return confirm('Approve this hotel?');">
                               Approve
                            </a>
                            <a href="?action=delete&id=<?= $row['id'] ?>" 
                               class="btn btn-danger btn-sm"
                               onclick="return confirm('Delete this hotel?');">
                               Delete
                            </a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="9" class="text-center">No pending hotels.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
