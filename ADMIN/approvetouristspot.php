<?php
include '../CONFIG/config.php';
include 'components/head.php';
include 'components/navbar.php';

// Fetch pending tourist spots
$result = $conn->query("SELECT ts.*, d.name as district_name 
                        FROM tourist_spots ts 
                        JOIN districts d ON ts.district_id = d.id 
                        WHERE ts.status = 'Pending' 
                        ORDER BY ts.id DESC");
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
    <h3 class="mb-4">⏳ Pending Tourist Spots</h3>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>District</th>
                    <th>Name</th>
                    <th>Image</th>
                    <th>Description</th>
                    <th width="200">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= htmlspecialchars($row['district_name']) ?></td>
                        <td><?= htmlspecialchars($row['name']) ?></td>
                        <td>
                            <img src="uploads/tourist_spots/<?= htmlspecialchars($row['image']) ?>" width="80" height="60" style="object-fit:cover;">
                        </td>
                        <td><?= htmlspecialchars(substr($row['description'], 0, 80)) ?>...</td>
                        <td>
                            <a href="set_status.php?id=<?= $row['id'] ?>&status=Approved" 
                               class="btn btn-success btn-sm"
                               onclick="return confirm('Approve this spot?');">
                               Approve
                            </a>
                            <a href="delete_tourist_spot.php?id=<?= $row['id'] ?>" 
                               class="btn btn-danger btn-sm"
                               onclick="return confirm('Delete this tourist spot?');">
                               Delete
                            </a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="6" class="text-center">No pending tourist spots.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
