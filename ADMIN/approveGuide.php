<?php
include '../CONFIG/config.php';
include 'components/head.php';
include 'components/navbar.php';

// Fetch pending guides
$result = $conn->query("SELECT g.*, d.name as district_name, t.name as spot_name 
                        FROM guides g
                        LEFT JOIN districts d ON g.district_id = d.id
                        LEFT JOIN tourist_spots t ON g.spot_id = t.id
                        WHERE g.status = 'Pending'
                        ORDER BY g.id DESC");
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
    <h3 class="mb-4">⏳ Pending Guides</h3>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Guide Name</th>
                    <th>Email</th>
                    <th>Mobile</th>
                    <th>District</th>
                    <th>Tourist Spot</th>
                    <th>Image</th>
                    <th>ID No</th>
                    <th width="200">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= htmlspecialchars($row['first_name'].' '.$row['last_name']) ?></td>
                        <td><?= htmlspecialchars($row['email']) ?></td>
                        <td><?= htmlspecialchars($row['mobile']) ?></td>
                        <td><?= htmlspecialchars($row['district_name']) ?></td>
                        <td><?= htmlspecialchars($row['spot_name']) ?></td>
                        <td>
                            <?php if(!empty($row['image'])): ?>
                                <img src="../GUIDE/uploads/guides/<?= htmlspecialchars($row['image']) ?>" width="80" height="60" style="object-fit:cover;">
                            <?php else: ?>
                                <span class="text-muted">No image</span>
                            <?php endif; ?>
                        </td>
                        <td><?= htmlspecialchars($row['id_card']) ?></td>
                        <td>
                            <a href="set_guide_status.php?id=<?= $row['id'] ?>&status=Approved" 
                               class="btn btn-success btn-sm"
                               onclick="return confirm('Approve this guide?');">
                               Approve
                            </a>
                            <a href="delete_guide.php?id=<?= $row['id'] ?>" 
                               class="btn btn-danger btn-sm"
                               onclick="return confirm('Delete this guide?');">
                               Delete
                            </a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="9" class="text-center">No pending guides.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
