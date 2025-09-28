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

// ✅ Handle Delete Request
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    $stmt = $conn->prepare("DELETE FROM contact_messages WHERE id = ?");
    $stmt->bind_param("i", $delete_id);
    $stmt->execute();
    $stmt->close();
    header("Location: viewContact.php?msg=deleted");
    exit();
}

// Fetch all contact messages
$result = $conn->query("SELECT cm.*, u.username 
                        FROM contact_messages cm
                        JOIN users u ON cm.user_id = u.id
                        ORDER BY cm.created_at DESC");
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
    <h3 class="mb-4">📩 User Contact Messages</h3>

    <?php if (isset($_GET['msg']) && $_GET['msg'] === 'deleted'): ?>
        <div class="alert alert-warning">Message deleted successfully.</div>
    <?php endif; ?>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Mobile</th>
                    <th>Message</th>
                    <th>Created At</th>
                    <th width="120">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= htmlspecialchars($row['username']) ?></td>
                        <td><?= htmlspecialchars($row['first_name'] . ' ' . $row['last_name']) ?></td>
                        <td><?= htmlspecialchars($row['email']) ?></td>
                        <td><?= htmlspecialchars($row['mobile']) ?></td>
                        <td><?= htmlspecialchars(substr($row['message'], 0, 100)) ?>...</td>
                        <td><?= htmlspecialchars($row['created_at']) ?></td>
                        <td>
                            <a href="viewContact.php?delete_id=<?= $row['id'] ?>" 
                               class="btn btn-danger btn-sm"
                               onclick="return confirm('Are you sure you want to delete this message?');">
                               Delete
                            </a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="8" class="text-center">No messages found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
